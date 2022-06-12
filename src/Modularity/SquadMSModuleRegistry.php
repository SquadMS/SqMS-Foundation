<?php

namespace SquadMS\Foundation\Modularity;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Collection;
use SquadMS\Foundation\Modularity\Contracts\SquadMSModule;
use SquadMS\Foundation\Modularity\Exceptions\DuplicateModuleException;
use SquadMS\Foundation\Modularity\Exceptions\InvalidModuleTypeException;

class SquadMSModuleRegistry
{
    private Collection $store;

    private Collection $registeredMenus;

    public function __construct()
    {
        $this->store = new Collection();
        $this->registeredMenus = new Collection();
    }

    public function register(string $module): void
    {
        if (!class_exists($module) || !is_subclass_of($module, SquadMSModule::class)) {
            throw new InvalidModuleTypeException('Modules have to extend the SquadMSModule Contract.');
        }

        if ($this->store->has($module::getIdentifier())) {
            throw new DuplicateModuleException('Modules can not be registeted twice!');
        }

        $this->store->put($module::getIdentifier(), $module);
    }

    public function publishAssets(): void
    {
        /** @var SquadMSModule $module */
        foreach ($this->store as $identifier => $module) {
            $module::publishAssets();
        }
    }
    
    public function overrideConfigs(): void
    {
        foreach ($this->store as $identifier => $module) {
            foreach ($module::overrideConfigs() as $config => $value) {
                Config::set([$config => $value]);
            }
        }
    }

    public function registerMenuEntries(string $menu): void
    {
        /* Do not register the same menu twice */
        if (!$this->registeredMenus->contains($menu)) {
            /** @var SquadMSModule $module */
            foreach ($this->store as $identifier => $module) {
                $module::registerMenuEntries($menu);
            }

            $this->registeredMenus->push($menu);
        }
    }

    public function runSchedulers(Schedule $schedule): void
    {
        /** @var SquadMSModule $module */
        foreach ($this->store as $identifier => $module) {
            $module::schedule($schedule);
        }
    }
}
