<?php

namespace SquadMS\Foundation\Providers;

use Illuminate\Support\ServiceProvider;
use SquadMS\Foundation\Console\DevPostInstall;
use SquadMS\Foundation\Console\PermissionsSync;
use SquadMS\Foundation\Console\PublishAssets;

class CommandsServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                PublishAssets::class,
                PermissionsSync::class,
                DevPostInstall::class,
            ]);
        }
    }
}
