<?php

namespace SquadMS\Foundation\Contracts;

use Spatie\LaravelPackageTools\Package;
use Filament\PluginServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

abstract class SquadMSModuleServiceProvider extends PluginServiceProvider
{
    use SquadMSAuthServiceProvider;

    protected array $routeFileNames = [];

    public function packageConfigured(Package $package): void
    {
        /* Register migrations if available */
        if ($migrations = array_diff(scandir($this->package->basePath('/../database/migrations')), ['..'. '.'])) {
            $package->hasMigrations($migrations);
        }
    
        $this->configureModule($package);
    }

    abstract public function configureModule(Package $package): void;

    public function registeringPackage()
    {
        /* Register any defined policies */
        $this->registerPolicies();

        /* Allow the module to run some registering code too */
        $this->registeringModule();
    }

    public function registeringModule(): void
    {
        //
    }

    public function bootingPackage()
    {
        /* Register migrations that exist */
        $this->package->hasMigrations(array_diff(scandir($this->package->basePath('/../database/migrations')), ['..'. '.']));

        /* Allow the module to run some booting code too */
        $this->bootingModule();

        /* Prevent routes from being registered during boot (allow sqms foundation to boot) */
        $this->routeFileNames = $this->package->routeFileNames;
        $this->package->routeFileNames = [];
    }

    public function bootingModule(): void
    {
        //
    }

    public function packageBooted(): void
    {
        /* Run parent booted method first */
        parent::packageBooted();

        /* Register routes once application / sqms foundation has booted */
        $this->app->booted(function() {
            foreach ($this->routeFileNames as $routeFileName) {
                $this->loadRoutesFrom("{$this->package->basePath('/../routes/')}{$routeFileName}.php");
            }
        });

        /* Register any NavigationTypes this module might have */
        $this->addNavigationTypes();

        /* Run Schedulers */
        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $this->schedule($schedule);
        });

        /* Allow the module to run some booted code too */
        $this->bootedModule();
    }

    public function bootedModule(): void
    {
        //
    }

    public function addNavigationTypes(): void
    {

    }

    public function schedule(Schedule $schedule): void
    {
        //
    }
}
