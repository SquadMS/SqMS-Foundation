<?php

namespace SquadMS\Foundation\Contracts;

use Filament\PluginServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use SquadMS\Foundation\Constraints\SquadMSAuthServiceProvider;
use SquadMS\Foundation\Facades\SquadMSModuleRegistry;
use SquadMS\Foundation\Facades\SquadMSSettings;

abstract class SquadMSModuleServiceProvider extends PluginServiceProvider
{
    use SquadMSAuthServiceProvider;

    protected array $routeFileNames = [];

    protected array $livewireComponents = [];

    public function packageConfiguring(Package $package): void
    {
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

        /* Register migrations */
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom([
                $this->package->basePath('../database/migrations'),
                $this->package->basePath('../database/settings'),
            ]);
        }

        /* Register routes once application / sqms foundation has booted */
        $this->app->booted(function () {
            foreach ($this->routeFileNames as $routeFileName) {
                $this->loadRoutesFrom("{$this->package->basePath('/../routes/')}{$routeFileName}.php");
            }
        });

        /* Register module settings */
        foreach ($this->settings() as $setting) {
            SquadMSSettings::register($setting);
        }

        /* Register any NavigationTypes this module might have */
        $this->addNavigationTypes();

        /* Run Schedulers */
        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $this->schedule($schedule);
        });

        /* Register Modularity (if it does exist) */
        if (class_exists($fqcn = substr(get_called_class(), 0, strrpos(get_called_class(), '\\')).'\\SquadMSModule')) {
            SquadMSModuleRegistry::register($fqcn);
        }

        /* Register Livewire Components */
        foreach ($this->livewireComponents as $name => $class) {
            Livewire::component(static::$name.'::'.$name, $class);
        }

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

    public function settings(): array
    {
        return [];
    }
}
