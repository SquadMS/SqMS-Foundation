<?php

namespace SquadMS\Foundation\Contracts;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

abstract class SquadMSModuleServiceProvider extends PackageServiceProvider
{
    use SquadMSAuthServiceProvider;

    protected array $routeFileNames = [];

    public function configurePackage(Package $package): void
    {
        /* Register migrations if available */
        if ($migrations = array_diff(scandir($this->package->basePath('/../database/migrations')), ['..'. '.'])) {
            $package->hasMigrations($migrations);
        }
       
        $this->configureModule($package);
    }

    public function configureModule(Package $package): void
    {
        //
    }

    public function registeringPackage()
    {
        /* Register any defined policies */
        $this->registerPolicies();

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

        $this->bootingModule();

        /* Prevent routes from being registered during boot (allow sqms foundation to boot) */
        $this->routeFileNames = $this->package->routeFileNames;
        $this->package->routeFileNames = [];
    }

    public function bootingModule(): void
    {
        //
    }

    public function packageBooted()
    {
        /* Register routes once application / sqms foundation has booted */
        $this->app->booted(function() {
            foreach ($this->routeFileNames as $routeFileName) {
                $this->loadRoutesFrom("{$this->package->basePath('/../routes/')}{$routeFileName}.php");
            }
        });

        $this->bootedModule();
    }

    public function bootedModule(): void
    {
        //
    }
}
