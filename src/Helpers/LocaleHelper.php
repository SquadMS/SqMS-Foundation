<?php

namespace SquadMS\Foundation\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

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

    static function getAvailableLocales(bool $excludeCurrent = false) : array
    {
        $available = Config::get('localized-routes.supported-locales', []);

        if ($excludeCurrent) {
            $available = array_values(Arr::except(array_combine($available, $available), [
                app()->getLocale(),
                app()->getLocale(),
            ]));
        }

        return $available;
    }

    static function isRTL(string $locale) : bool
    {
        return in_array($locale, [
            'ar',
        ]);
    }
}
