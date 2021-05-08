<?php

namespace SquadMS\Foundation\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use SquadMS\Foundation\SquadMSRouter;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(SquadMSRouter::class, function () {
            return new SquadMSRouter();
        });
    }

    public function register()
    {
        /* Middlewares */
        //$router = $this->app->make(Router::class);
        //$router->aliasMiddleware('can', \SquadMS\Foundation\Admin\Http\Middleware\CheckPermissions::class);

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