<?php

namespace SquadMS\Foundation\Modularity;

use Illuminate\Support\Collection;
use SquadMS\Foundation\Modularity\Contracts\SquadMSModule;
use SquadMS\Foundation\Modularity\Exceptions\DuplicateModuleException;
use SquadMS\Foundation\Modularity\Exceptions\InvalidModuleTypeException;

class SquadMSModuleRegistry
{
    private Collection $store;

    function __construct()
    {
        $this->store = new Collection();
    }

    public function register(string $module) : void
    {
        if (!class_exists($module) || !is_subclass_of($module, SquadMSModule::class)) {
            throw new InvalidModuleTypeException('Modules have to extend the SquadMSModule Contract.');
        }

        if ($this->store->has($module::getIdentifier())) {
            throw new DuplicateModuleException('Modules can not be registeted twice!');
        }

        $this->store->put($module::getIdentifier(), $module);
    }

    public function publishAssets() : void
    {
        /** @var SquadMSModule $module */
        foreach ($this->store as $identifier => $module) {
            $module->publishAssets();
        }
    }
}