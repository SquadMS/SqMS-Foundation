<?php

use Illuminate\Support\Facades\Config;
use SquadMS\Foundation\Helpers\SquadMSRouteHelper;

SquadMSRouteHelper::configurableRoutes(Config::get('sqms.routes.def', []));