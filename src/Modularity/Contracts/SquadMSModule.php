<?php

namespace SquadMS\Foundation\Modularity\Contracts;

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
}
