<?php

namespace SquadMS\Foundation\SDKData;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class SDKDataReader
{
    private ?array $_data = null;

    public function getFactionForTeamID(string $layerOrRawName, int $teamID): ?string
    {
        return Cache::tags('sqms-sdkdata')->rememberForever('sqms-sdkdata-faction-for-teamID-'.md5($layerOrRawName.$teamID), function () use ($layerOrRawName, $teamID) {
            /* Find map data */
            $data = $this->getMapData($layerOrRawName);

            /* Check if we found the map data */
            if ($data) {
                /* Return the correct faction name from the data (or false since it is cacheable */
                return Arr::get($data, 'team'.$teamID.'.faction', false);
            }

            return false;
        }) ?: null;
    }

    public function getSetupForTeamID(string $layerOrRawName, int $teamID): ?string
    {
        return Cache::tags('sqms-sdkdata')->rememberForever('sqms-sdkdata-setup-for-teamID-'.md5($layerOrRawName.$teamID), function () use ($layerOrRawName, $teamID) {
            /* Find map data */
            $data = $this->getMapData($layerOrRawName);

            /* Check if we found the map data */
            if ($data) {
                /* Return the correct faction name from the data (or false since it is cacheable */
                return Arr::get($data, 'team'.$teamID.'.teamSetupName', false);
            }

            return false;
        }) ?: null;
    }

    public function getLayerForRaw(string $rawName): ?string
    {
        return Cache::tags('sqms-sdkdata')->rememberForever('sqms-sdkdata-layer-for-rawname-'.md5($rawName), function () use ($rawName) {
            /* Find map data */
            $data = $this->getMapData($rawName);

            return $data ? Arr::get($data, 'levelName', false) : false;
        }) ?: null;
    }

     /**
     * Convert an SDKData rawName/layer to ingame Level name.
     * 
     * @return string|null
     */
    public static function layerToLevel(string $layerOrRaw): ?string
    {
        /* Squad Maps */
        if (Str::startsWith($layerOrRaw, ['Albasrah_', 'CAF_Al_Basrah_', 'AlBasrah_', 'CAF_AlBasrah_' ])) {
            return 'Al Basrah';
        } else if (Str::startsWith($layerOrRaw, ['Belaya_', 'CAF_Belaya_'])) {
            return 'Belaya';
        } else if (Str::startsWith($layerOrRaw, ['Chora_AAS_', 'CAF_Chora_'])) {
            return 'Chora';
        } else if (Str::startsWith($layerOrRaw, ['Fallujah_', 'CAF_Fallujah_'])) {
            return 'Fallujah';
        } else if (Str::startsWith($layerOrRaw, ['Fools_Road_', 'CAF_Fools_Road_', 'FoolsRoad_'])) {
            return 'Fool\'s Road';
        } else if (Str::startsWith($layerOrRaw, ['Gorodok_', 'CAF_Gorodok_'])) {
            return 'Gorodok';
        } else if (Str::startsWith($layerOrRaw, ['Kamdesh_', 'CAF_Kamdesh_'])) {
            return 'Kamdesh Highlands';
        } else if (Str::startsWith($layerOrRaw, ['Kohat_', 'CAF_Kohat_'])) {
            return 'Kohat Toi';
        } else if (Str::startsWith($layerOrRaw, ['Kokan_', 'CAF_Kokan_Valley_', 'Kokan_Valley_'])) {
            return 'Kokan';
        } else if (Str::startsWith($layerOrRaw, ['Lashkar_Valley_', 'CAF_Lashkar_Valley_', 'LashkarValley_'])) {
            return 'Lashkar Valley';
        } else if (Str::startsWith($layerOrRaw, ['Logar_Valley_', 'CAF_Logar_Valley_', 'Logar_'])) {
            return 'Logar Valley';
        } else if (Str::startsWith($layerOrRaw, ['Mestia_', 'CAF_Mestia'])) {
            return 'Mestia';
        } else if (Str::startsWith($layerOrRaw, ['Mutaha_', 'CAF_Mutaha_'])) {
            return 'Mutaha';
        } else if (Str::startsWith($layerOrRaw, ['Narva_', 'CAF_Narva_'])) {
            return 'Narva';
        } else if (Str::startsWith($layerOrRaw, ['Skorpo_', 'CAF_Skorpo_'])) {
            return 'Skorpo';
        } else if (Str::startsWith($layerOrRaw, ['Sumari_', 'CAF_Sumari_'])) {
            return 'Sumari';
        } else if (Str::startsWith($layerOrRaw, ['Tallil_Outskirts_', 'CAF_Tallil_Outskirts_', 'Tallil_'])) {
            return 'Tallil Outskirts';
        } else if (Str::startsWith($layerOrRaw, ['Yehorivka_', 'CAF_Yehorivka_'])) {
            return 'Yehorivka';
        }

        /* Special maps */
        else if (Str::startsWith($layerOrRaw, ['Jensens_Range_', 'CAF_Jensens_Range_', 'JensensRange_', 'CAF_JensensRange_'])) {
            return 'Jensen\'s Range';
        } else if (Str::startsWith($layerOrRaw, ['Helicopter_Tutorial', 'Tutorial_Helicopter'])) {
            return 'Tutorials';
        } else if (Str::startsWith($layerOrRaw, ['Infantry_Tutorial', 'Tutorial_Infantry'])) {
            return 'Tutorials';
        }
        
        /* CAF Maps */
        else if (Str::startsWith($layerOrRaw, ['CAF_Manic_', 'CAF_Manic-5_'])) {
            return 'Manic-5';
        } else if (Str::startsWith($layerOrRaw, ['CAF_Goose_Bay_', 'CAF_GooseBay_'])) {
            return 'Goose Bay';
        }

        return null;
    }

    private function getMapData(string $layerOrRawName): ?array
    {
        /* Find layer */
        foreach (Arr::get($this->getData(), 'Maps', []) as $map) {
            /* Check if layerOrRawName does match this map, if not continue */
            if (Arr::get($map, 'levelName') !== $layerOrRawName && Arr::get($map, 'rawName') !== $layerOrRawName) {
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
