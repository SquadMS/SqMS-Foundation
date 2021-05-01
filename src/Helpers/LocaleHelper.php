<?php

namespace SquadMS\Foundation\Helpers;

class LocaleHelper {
    static function getHumanReadableName(string $locale) : ?string
    {
        switch($locale) {
            case 'de':
                return 'Deutsch';
            case 'en':
                return 'English';
            default:
                return null;
        }
    }
}
