<?php

namespace SquadMS\Foundation\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\View\ComponentAttributeBag;
use SquadMS\Foundation\Facades\SquadMSAdminMenu as FacadesSquadMSAdminMenu;
use SquadMS\Foundation\SquadMSRouter;
use SquadMS\Foundation\Facades\SquadMSRouter as FacadesSquadMSRouter;
use SquadMS\Foundation\Menu\SquadMSMenu;
use SquadMS\Foundation\Facades\SquadMSMenu as FacadesSquadMSMenu;
use SquadMS\Foundation\Helpers\NavigationHelper;
use SquadMS\Foundation\Menu\SquadMSAdminMenu;
use SquadMS\Foundation\Menu\SquadMSMenuEntry;
use SquadMS\Foundation\Menu\SquadMSMenuHTMLEntry;

class RouteServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SquadMSRouter::class, function () {
            return new SquadMSRouter();
        });

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
        $routesPath = __DIR__ . '/../../routes';
        FacadesSquadMSRouter::define('sqms-foundation', function () use ($routesPath) {
            Route::group([
                'prefix' => config('sqms.routes.prefix'),
                'middleware' => config('sqms.routes.middleware'),
            ], function () use ($routesPath) {
                $this->loadRoutesFrom($routesPath . '/web.php');
            });
        });

        /* Public Menu */
        FacadesSquadMSMenu::register(
            'main-left',
            (new SquadMSMenuEntry(Config::get('sqms.routes.def.home.name'), __('sqms-foundation::navigation.home'), true))
            ->setActive( fn (SquadMSMenuEntry $link) => NavigationHelper::isCurrentRoute(Config::get('sqms.routes.def.home.name')) )
            ->setOrder(100)
        );

        FacadesSquadMSMenu::register(
            'main-left',
            (new SquadMSMenuEntry(Config::get('sqms.routes.def.admin-dashboard.name'), __('sqms-foundation::navigation.admin'), true))
            ->setCondition(Config::get('sqms.permissions.module') . ' admin')
            ->setOrder(PHP_INT_MAX) // Always last item
        );

        FacadesSquadMSMenu::register(
            'main-right',
            (new SquadMSMenuEntry(Config::get('sqms.routes.def.profile.name'), __('sqms-foundation::navigation.profile'), true, function () {
                return ['steam_id_64' => Auth::user()->steam_id_64];
            }))
            ->setCondition(fn () => Auth::check())
            ->setActive(fn () => NavigationHelper::isCurrentRoute(Config::get('sqms.routes.def.profile.name')) && Request::route('steam_id_64') === Auth::user()->steam_id_64)
            ->setOrder(100)
        );

        FacadesSquadMSMenu::register(
            'main-right',
            (new SquadMSMenuHTMLEntry(function () {
                return view(Config::get('sqms.theme') . '::' . Config::get('sqms.menu.entry-view'), [
                    'attributes' => new ComponentAttributeBag([
                        'onclick' => 'event.preventDefault(); document.getElementById(\'frm-logout\').submit();'
                    ]),
                    'link'   => route(Config::get('sqms.routes.def.logout.name')),
                    'title'  => __('sqms-foundation::navigation.logout'),
                    'slot'   => '<form id="frm-logout" action="'.route(Config::get('sqms.routes.def.logout.name')).'" method="POST" style="display: none;">'.csrf_field().'</form>'
                ])->render();
            }))
            ->setCondition(fn () => Auth::check())
            ->setOrder(200)
        );

        FacadesSquadMSMenu::register(
            'main-right',
            (new SquadMSMenuEntry(Config::get('sqms.routes.def.steam-login.name'), __('sqms-foundation::navigation.login'), true))
            ->setCondition(fn () => !Auth::check())
            ->setOrder(100)
        );

        /* Admin Menu */
        FacadesSquadMSAdminMenu::register('admin', 0);

        FacadesSquadMSMenu::register(
            'admin',
            (new SquadMSMenuEntry(Config::get('sqms.routes.def.admin-dashboard.name'), '<i class="bi bi-house-fill"></i> Dashboard', true))->setView('sqms-foundation::components.navigation.item')
            ->setActive( fn (SquadMSMenuEntry $link) => NavigationHelper::isCurrentRoute(Config::get('sqms.routes.def.admin-dashboard.name')) )
            ->setOrder(100)
        );

        FacadesSquadMSAdminMenu::register('admin-system', PHP_INT_MAX);
        FacadesSquadMSMenu::prepend('admin-system', view('sqms-foundation::components.navigation.heading', [
            'title'  => 'System',
        ])->render());

        FacadesSquadMSMenu::register(
            'admin-system',
            (new SquadMSMenuEntry(Config::get('sqms.routes.def.admin-rbac.name'), '<i class="bi bi-shield-lock-fill"></i> RBAC', true))->setView('sqms-foundation::components.navigation.item')
            ->setActive( fn (SquadMSMenuEntry $link) => NavigationHelper::isCurrentRoute(Config::get('sqms.routes.def.admin-rbac.name')) )
            ->setCondition(Config::get('sqms.permissions.module') . ' admin rbac')
            ->setOrder(100)
        );
    }
}