<?php

namespace SquadMS\Foundation\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use PeterColes\Languages\LanguagesFacade;

class LocaleHelper {
    static function getHumanReadableName(string $locale) : ?string
    {
        /* Lookup language names for the current language */
        $lookup = LanguagesFacade::lookup(self::getAvailableLocales(), App::getLocale());

        /* Get the translated locale or null */
        return Arr::get($lookup, $locale, null);
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
