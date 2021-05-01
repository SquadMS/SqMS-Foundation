<?php

namespace SquadMS\Foundation;

use Illuminate\Container\Container;
use Illuminate\Routing\Router;
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
        $this->app->singleton(SteamLogin::class, function () {
            return new SteamLogin(fn () => Container::getInstance());
        });

        $this->app->singleton(SquadMSRouter::class, function () {
            return new SquadMSRouter();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /* Configuration */
        $this->mergeConfigFrom(__DIR__ . '/../config/sqms.php', 'sqms');

        /* Migrations */
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        /* Middlewares */
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('checkAdminAreaAccess', \SquadMS\Foundation\Admin\Http\Middleware\CheckAdminAreaAccess::class);

        /* Routes */
        SquadMSRouter::getInstance()->define('squadms-foundation', function () {
            Route::group([
                'prefix' => config('sqms.routes.prefix'),
                'middleware' => config('sqms.routes.middleware'),
            ], function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
            });
        });
    }
}