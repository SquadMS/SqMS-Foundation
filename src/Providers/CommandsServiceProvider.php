<?php

namespace SquadMS\Foundation\Providers;

use Illuminate\Support\ServiceProvider;
use JohnDoe\BlogPackage\Console\PublishAssets;

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
            ]);
        }
    }
}