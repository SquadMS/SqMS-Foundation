<?php

namespace SquadMS\Foundation\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use SquadMS\Foundation\Menu\SquadMSAdminMenu;
use SquadMS\Foundation\Menu\SquadMSMenu;

class RouteServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SquadMSMenu::class, function () {
            return new SquadMSMenu();
        });

        $this->app->singleton(SquadMSAdminMenu::class, function () {
            return new SquadMSAdminMenu();
        });
    }

    public function boot()
    {
        /* Middlewares */
        //$router = $this->app->make(Router::class);
        //$router->aliasMiddleware('can', \SquadMS\Foundation\Admin\Http\Middleware\CheckPermissions::class);

        /* Routes */
        $routesPath = __DIR__.'/../../routes';
        Route::group([
            'prefix'     => config('sqms.routes.prefix'),
            'middleware' => config('sqms.routes.middleware'),
        ], function () use ($routesPath) {
            $this->loadRoutesFrom($routesPath.'/web.php');
        });
    }
}
