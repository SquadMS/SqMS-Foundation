<?php

namespace SquadMS\Foundation\Modularity\Contracts;

use Illuminate\Console\Scheduling\Schedule;


abstract class SquadMSModule
{
    abstract static function getIdentifier() : string;

    abstract static function getName() : string;

    abstract static function publishAssets() : void;

    abstract static function registerAdminMenus() : void;

    abstract static function registerMenuEntries(string $menu) : void;

    abstract static function schedule(Schedule $schedule) : void;
}