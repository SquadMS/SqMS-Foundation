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
                Route::localized(function () use ($define) {
                    $define();
                }, [
                    'supported-locales' => Config::get('sqms.locales')
                ]);
            } else {
                $define();
            }
        }
    }
}
