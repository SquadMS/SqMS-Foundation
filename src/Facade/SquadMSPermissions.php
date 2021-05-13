<?php

namespace SquadMS\Foundation\Facade;

use Illuminate\Support\Facades\Facade;
use SquadMS\Foundation\SquadMSPermissions as FoundationSquadMSPermissions;

class SquadMSPermissions extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return FoundationSquadMSPermissions::class;
    }
}