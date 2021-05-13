<?php

namespace SquadMS\Foundation\Facades;

use Illuminate\Support\Facades\Facade;
use SquadMS\Foundation\SquadMSRouter as FoundationSquadMSRouter;

class SquadMSRouter extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return FoundationSquadMSRouter::class;
    }
}