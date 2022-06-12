<?php

namespace SquadMS\Foundation\Modularity\Contracts;

use Illuminate\Console\Scheduling\Schedule;

abstract class SquadMSModule
{
    abstract public static function getIdentifier(): string;

    abstract public static function getName(): string;

    public static function publishAssets(): void
    {
        //
    }

    public static function registerMenuEntries(string $menu): void
    {
        //
    }

    public static function schedule(Schedule $schedule): void
    {
        //
    }
}
