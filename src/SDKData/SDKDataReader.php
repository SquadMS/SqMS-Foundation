<?php

namespace SquadMS\Foundation\SDKData;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class SDKDataReader
{
    private ?array $_data = null;

    public function getFactionForSetupName(string $setupName, ?string $mapName = null) : ?string
    {
        return Cache::tags('sqms-sdkdata')->rememberForever('sqms-sdkdata-faction-for-setup-' . md5($setupName), function () use ($setupName, $mapName) {
            /* Find level */
            foreach (Arr::get($this->getData(), 'Maps', []) as $map) {
                if (!is_null($mapName) && Arr::get($map, 'Name') !== $mapName) {
                    continue;
                }

                foreach (['team1', 'team2'] as $team) {
                    if (Arr::get($map, $team . '.teamSetupName') === $setupName) {
                        return Arr::get($map, $team . '.faction');
                    }
                }
            }

            return false;
        }) ?: null;
    }

    /**
     * Get the current dataset. Will load the data from GitHub
     * if no data has already been loaded.
     *
     * @return array
     */
    private function getData() : array
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