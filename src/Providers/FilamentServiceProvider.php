<?php

namespace SquadMS\Foundation\Providers;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;
use SquadMS\Foundation\Filament\Resources\RBACResource;

class FilamentServiceProvider extends PluginServiceProvider
{
    protected array $resources = [
        RBACResource::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package->name('sqms-foundation');
    }
}
