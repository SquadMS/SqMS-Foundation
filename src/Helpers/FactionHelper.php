<?php

namespace SquadMS\Foundation\Helpers;

use Illuminate\Support\Str;
use SquadMS\Foundation\Facades\SDKDataReader;

class FactionHelper
{
    public static function getFactionTag(string $layerOrRaw, int $teamID): string
    {
        $factionName = SDKDataReader::getFactionForTeamID($layerOrRaw, $teamID);

        if (!is_null($factionName)) {
            if (Str::contains($factionName, ['Canadian Army'])) {
                return 'caf';
            } elseif (Str::contains($factionName, ['Irregular Militia Forces'])) {
                return 'im';
            } elseif (Str::contains($factionName, ['Insurgent Forces'])) {
                return 'ins';
            } elseif (Str::contains($factionName, ['Russian Ground Forces'])) {
                return 'ru';
            } elseif (Str::contains($factionName, ['British Army'])) {
                return 'uk';
            } elseif (Str::contains($factionName, ['United States Army'])) {
                return 'us';
            } elseif (Str::contains($factionName, ['United States Marine Corps'])) {
                return 'usmc';
            } elseif (Str::contains($factionName, ['Middle Eastern Alliance'])) {
                return 'mea';
            }
        }

        return 'us';
    }
}
