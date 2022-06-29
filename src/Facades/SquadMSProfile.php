<?php

namespace SquadMS\Foundation\Facades;

use Illuminate\Support\Facades\Facade;
use SquadMS\Foundation\Profile\ProfileManager;

class SquadMSProfile extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ProfileManager::class;
    }
}
