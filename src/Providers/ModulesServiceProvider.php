<?php

namespace SquadMS\Foundation\Providers;

use Illuminate\Support\ServiceProvider;
use SquadMS\Foundation\Facades\SquadMSModuleRegistry as FacadesSquadMSModuleRegistry;
use SquadMS\Foundation\Modularity\SquadMSModuleRegistry;
use SquadMS\Foundation\SquadMSModule;

class ModulesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SquadMSModuleRegistry::class, function () {
            return new SquadMSModuleRegistry();
        });
    }

    public function boot()
    {
        FacadesSquadMSModuleRegistry::register(SquadMSModule::class);
    }
}
