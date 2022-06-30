<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use SquadMS\Foundation\Helpers\SquadMSRouteHelper;

Route::group([
    'prefix'     => Config::get('sqms.routes.prefix'),
    'middleware' => Config::get('sqms.routes.middleware'),
], function () {
    SquadMSRouteHelper::configurableRoutes(Config::get('sqms.routes.def', []));
});
