<?php

namespace SquadMS\Foundation\SDKData;

use Illuminate\Support\Arr;
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
