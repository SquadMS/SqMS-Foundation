<?php

namespace SquadMS\Foundation\Modularity;

use Illuminate\Support\Collection;
use SquadMS\Foundation\Modularity\Contracts\SquadMSModule;
use SquadMS\Foundation\Modularity\Exceptions\DuplicateModuleException;

class SquadMSModuleRegistry
{
    private Collection $store;

    function __construct()
    {
        $this->store = new Collection();
    }

    public function register(SquadMSModule $module) : void
    {
        if ($this->store->has($module->getIdentifier())) {
            throw new DuplicateModuleException('Modules can not be registeted twice!');
        }

        $this->store->put($module->getIdentifier(), $module);
    }

    public function publishAssets() : void
    {
        /** @var SquadMSModule $module */
        foreach ($this->store as $identifier => $module) {
            $module->publishAssets();
        }
    }
}