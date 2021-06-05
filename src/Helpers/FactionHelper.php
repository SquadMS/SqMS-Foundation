<?php

namespace SquadMS\Foundation\Helpers;

use Illuminate\Support\Str;
use SquadMS\Foundation\Facades\SDKDataReader;

class FactionHelper
{
    static function getFactionTag(string $setupName, ?string $mapName = null) : string
    {
        $factionName = SDKDataReader::getFactionForSetupName($setupName, $mapName);

        if (!is_null($factionName)) {
            if (Str::contains($factionName, ['Canadian Army'])) {
                return 'caf';
            } else if (Str::contains($factionName, ['Irregular Militia Forces'])) {
                return 'im';
            } else if (Str::contains($factionName, ['Insurgent Forces'])) {
                return 'ins';
            } else if (Str::contains($factionName, ['Russian Ground Forces'])) {
                return 'ru';
            } else if (Str::contains($factionName, ['British Army'])) {
                return 'uk';
            } else if (Str::contains($factionName, ['United States Army'])) {
                return 'us';
            } else if (Str::contains($factionName, ['United States Marine Corps'])) {
                return 'usmc';
            } else if (Str::contains($factionName, ['Middle Eastern Alliance'])) {
                return 'mea';
            }
        }
        
        return 'us';
    }
}