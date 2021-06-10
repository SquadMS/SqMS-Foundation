<?php

namespace SquadMS\Foundation\Facades;

use Illuminate\Support\Facades\Facade;
use SquadMS\Foundation\Modularity\SquadMSModuleRegistry as FoundationSquadMSModuleRegistry;

class SquadMSModuleRegistry extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return FoundationSquadMSModuleRegistry::class;
    }
}
