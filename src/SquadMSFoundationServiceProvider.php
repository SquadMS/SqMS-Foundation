<?php

namespace SquadMS\Foundation;

use Illuminate\Support\Facades\Route;
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
        $this->mergeConfigFrom(__DIR__ . '/../config/sqms.php', 'sqms');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        Route::group([
            'prefix' => config('sqms.routes.prefix'),
            'middleware' => config('sqms.routes.middleware'),
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }
}