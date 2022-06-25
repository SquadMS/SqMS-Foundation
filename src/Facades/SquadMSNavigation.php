<?php

namespace SquadMS\Foundation\Facades;

use Illuminate\Support\Facades\Facade;
use SquadMS\Foundation\Menu\MenuManager;

class SquadMSNavigation extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return MenuManager::class;
    }
}
