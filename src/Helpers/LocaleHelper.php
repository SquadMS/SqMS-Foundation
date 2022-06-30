<?php

namespace SquadMS\Foundation\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class LocaleHelper
{
    public static function getAvailableLocales(bool $excludeCurrent = false): array
    {
        $available = Config::get('sqms.locales', []);

        if ($excludeCurrent) {
            $available = array_values(Arr::except(array_combine($available, $available), [
                app()->getLocale(),
                app()->getLocale(),
            ]));
        }

        return $available;
    }

    public static function localeToFlagIconsCSS(string $locale): string
    {
        return 'fi-'.(string) Str::of($locale)
            ->replace('en', 'us')
            ->replace('he', 'il');
    }

    public static function isRTL(string $locale): bool
    {
        return in_array($locale, [
            'ar',
            'arc',
            'ckb',
            'dv',
            'fa',
            'ha	',
            'he',
            'khw',
            'ks',
            'ps',
            'ur',
            'uz_AF',
            'yi',
        ]);
    }
}
