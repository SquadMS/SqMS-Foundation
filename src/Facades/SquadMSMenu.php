<?php

namespace SquadMS\Foundation\Facades;

use Illuminate\Support\Facades\Facade;
use SquadMS\Foundation\Menu\SquadMSMenu as FoundationSquadMSMenu;

class SquadMSMenu extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return FoundationSquadMSMenu::class;
    }
}