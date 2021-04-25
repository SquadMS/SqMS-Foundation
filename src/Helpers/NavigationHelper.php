<?php

namespace SquadMS\Foundation\Helpers;

use Illuminate\Support\Facades\Route;

class NavigationHelper {
    static function isCurrentRoute(string $name) : bool
    {
        foreach (config('localized-routes.supported-locales') as $locale) {
            if (Route::currentRouteNamed($locale . '.' . $name)) {
                return true;
            }
        }

        return Route::currentRouteNamed($name);
    }
}
