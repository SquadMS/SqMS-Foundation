<?php

namespace SquadMS\Foundation\Helpers;

use Illuminate\Support\Arr;

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

    static function getAvailableLocales(bool $excludeCurrent) : array
    {
        $available = config('localized-routes.supported-locales', []);

        if ($excludeCurrent) {
            $available = array_values(Arr::except(array_combine($available, $available), [
                app()->getLocale(),
                app()->getLocale(),
            ]));
        }

        return $available;
    }
}
