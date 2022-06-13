<?php

namespace SquadMS\Foundation\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;

class SquadMSRouteHelper
{
    public static function configurableRoutes(array $definitions): void
    {
        /* Define routes from config */
        foreach ($definitions as $definition) {
            /* Create the definitor as an anonymous function */
            $define = function () use ($definition) {
                $type = Arr::get($definition, 'type', 'get');
                Route::$type(Arr::get($definition, 'path', '/'), [Arr::get($definition, 'controller'), Arr::get($definition, 'executor', 'show')])->middleware(Arr::get($definition, 'middlewares'))->name(Arr::get($definition, 'name'));
            };

            if (Arr::get($definition, 'localized', false)) {
                self::localized($define);
            } else {
                $define();
            }
        }
    }
    
    public static function localized(Closure $closure): void
    {
        Route::localized(function () use ($closure) {
            $closure();
        }, [
            'supported-locales' => Config::get('sqms.locales'),
            'omit_url_prefix_for_locale' => Config::get('sqms.default_locale'),
            'use_locale_middleware' => true
        ]);
    }
}
