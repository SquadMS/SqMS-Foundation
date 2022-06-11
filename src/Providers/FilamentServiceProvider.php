<?php

namespace SquadMS\Foundation\Providers;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;
use SquadMS\Foundation\Filament\Pages\RBAC;

class FilamentServiceProvider extends PluginServiceProvider
{
    protected array $pages = [
        RBAC::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package->name('sqms-foundation');
    }
}
