<?php

namespace SquadMS\Foundation;

use Illuminate\Support\ServiceProvider;
use SquadMS\Foundation\Auth\SteamLogin;

class SquadMSFoundationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SteamLogin::class, function ($app) {
            return new SteamLogin($app);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}