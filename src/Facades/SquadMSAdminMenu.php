<?php

namespace SquadMS\Foundation\Facades;

use Illuminate\Support\Facades\Facade;
use SquadMS\Foundation\Menu\SquadMSAdminMenu as FoundationSquadMSAdminMenu;

class SquadMSAdminMenu extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return FoundationSquadMSAdminMenu::class;
    }
}