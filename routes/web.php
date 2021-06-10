<?php

use Illuminate\Support\Facades\Config;
use SquadMS\Foundation\Facades\SquadMSRouter;

SquadMSRouter::webRoutes(Config::get('sqms.routes.def', []));
