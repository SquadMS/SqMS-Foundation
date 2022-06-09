<?php

namespace SquadMS\Foundation\SDKData;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SDKDataReader
{
    const LEVEL_LAYER_NAMES = [
        'Al Basrah' => [
            'Albasrah_',
            'CAF_Al_Basrah_',
            'AlBasrah_',
            'CAF_AlBasrah_',
            'Al Basrah ',
            'CAF Al Basrah ',
        ],
        'Belaya' => [
            'Belaya_',
            'CAF_Belaya_',
        ],
        'Chora' => [
            'Chora_',
            'CAF_Chora_',
        ],
        'Fallujah' => [
            'Fallujah_',
            'CAF_Fallujah_',
        ],
        'Fool\'s Road' => [
            'Fools_Road_',
            'CAF_Fools_Road_',
            'FoolsRoad_',
        ],
        'Gorodok' => [
            'Gorodok_',
            'CAF_Gorodok_',
        ],
        'Kamdesh Highlands' => [
            'Kamdesh_',
            'CAF_Kamdesh_',
        ],
        'Kohat Toi' => [
            'Kohat_',
            'CAF_Kohat_',
        ],
        'Kokan' => [
            'Kokan_',
            'CAF_Kokan_Valley_',
            'Kokan_Valley_',
            'CAF Kokan ',
        ],
        'Lashkar Valley' => [
            'Lashkar_Valley_',
            'CAF_Lashkar_Valley_',
            'LashkarValley_',
        ],
        'Logar Valley' => [
            'Logar_Valley_',
            'CAF_Logar_Valley_',
            'Logar_',
        ],
        'Mestia' => [
            'Mestia_',
            'CAF_Mestia',
        ],
        'Mutaha' => [
            'Mutaha_',
            'CAF_Mutaha_',
        ],
        'Narva' => [
            'Narva_',
            'CAF_Narva_',
        ],
        'Skorpo' => [
            'Skorpo_',
            'CAF_Skorpo_',
        ],
        'Sumari Bala' => [
            'Sumari_',
            'CAF_Sumari_',
        ],
        'Tallil Outskirts' => [
            'Tallil_Outskirts_',
            'CAF_Tallil_Outskirts_',
            'Tallil_',
        ],
        'Yehorivka' => [
            'Yehorivka_',
            'CAF_Yehorivka_',
        ],
        'Jensen\'s Range' => [
            'Jensens_Range_',
            'CAF_Jensens_Range_',
            'JensensRange_',
            'CAF_JensensRange_',
        ],
        'Tutorials' => [
            'Helicopter_Tutorial',
            'Tutorial_Helicopter',
            'Infantry_Tutorial',
            'Tutorial_Infantry',
        ],
        'Manic-5' => [
            'CAF_Manic_',
            'CAF_Manic-5_',
        ],
        'Goose Bay' => [
            'CAF_Goose_Bay_',
            'CAF_GooseBay_',
        ],
    ];

    private ?array $_data = null;

    public function getFactionForTeamID(string $layerOrRawOrName, int $teamID): ?string
    {
        return Cache::tags('sqms-sdkdata')->rememberForever('sqms-sdkdata-faction-for-teamID-'.md5($layerOrRawOrName.$teamID), function () use ($layerOrRawOrName, $teamID) {
            /* Find map data */
            $data = $this->getMapData($layerOrRawOrName);

            /* Check if we found the map data */
            if ($data) {
                /* Return the correct faction name from the data (or false since it is cacheable */
                return Arr::get($data, 'team'.$teamID.'.faction', false);
            }

            return false;
        }) ?: null;
    }

    public function getSetupForTeamID(string $layerOrRawOrName, int $teamID): ?string
    {
        return Cache::tags('sqms-sdkdata')->rememberForever('sqms-sdkdata-setup-for-teamID-'.md5($layerOrRawOrName.$teamID), function () use ($layerOrRawOrName, $teamID) {
            /* Find map data */
            $data = $this->getMapData($layerOrRawOrName);

            /* Check if we found the map data */
            if ($data) {
                /* Return the correct faction name from the data (or false since it is cacheable */
                return Arr::get($data, 'team'.$teamID.'.teamSetupName', false);
            }

            return false;
        }) ?: null;
    }

    /**
     * Tries to find the real layer name from a Layers display Name (from ShowCurrentMap).
     * THIS WILL NOT WORK FOR JENSENS RANGE AS THEY ALL HAVE THE SAME DISPLAY NAME!
     *
     * @param string $layerDisplayName
     *
     * @return string|null
     */
    public function getLayer(string $layerDisplayName): ?string
    {
        return Cache::tags('sqms-sdkdata')->rememberForever('sqms-sdkdata-layer-for-layer-display-name-'.md5($layerDisplayName), function () use ($layerDisplayName) {
            /* Find map data */
            $data = $this->getMapData($layerDisplayName);

            return $data ? Arr::get($data, 'rawName', false) : false;
        }) ?: null;
    }

    /**
     * Convert an SDKData rawName/layer to ingame Level name.
     * TODO: Use mapName after Wiki-Team fixed it.
     *
     * @return string|null
     */
    public static function layerToLevel(string $layer): ?string
    {
        foreach (self::LEVEL_LAYER_NAMES as $level => $layerNames) {
            foreach ($layerNames as $layerName) {
                if (Str::startsWith($layer, [$layerName, Str::replace('_', ' ', $layerName)])) {
                    return $level;
                }
            }
        }

        return null;
    }

    private function getMapData(string $layerOrRawOrName): ?array
    {
        /* Find layer */
        foreach (Arr::get($this->getData(), 'Maps', []) as $map) {
            /* Check if layerOrRawOrName does match the Layer or it's display name */
            if (Arr::get($map, 'rawName') !== $layerOrRawOrName && Arr::get($map, 'Name') !== $layerOrRawOrName) {
                continue;
            }

            return $map;
        }

        return null;
    }

    /**
     * Get the current dataset. Will load the data from GitHub
     * if no data has already been loaded.
     *
     * @return array
     */
    private function getData(): array
    {
        /* Lazy load data file */
        if (is_null($this->_data)) {
            $response = Http::get(Config::get('sqms.sdkdata.data-url'));

            if ($response->ok()) {
                $this->_data = $response->json();
            } else {
                throw new \Exception('Could not load remote map data from GitHub');
            }
        }

        return $this->_data;
    }
}
