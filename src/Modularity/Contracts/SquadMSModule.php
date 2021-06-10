<?php

namespace SquadMS\Foundation\Modularity\Contracts;

use Illuminate\Console\Scheduling\Schedule;

abstract class SquadMSModule
{
    abstract public static function getIdentifier(): string;

    abstract public static function getName(): string;

    abstract public static function publishAssets(): void;

    abstract public static function registerAdminMenus(): void;

    abstract public static function registerMenuEntries(string $menu): void;

    abstract public static function schedule(Schedule $schedule): void;
}
