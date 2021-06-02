<?php

namespace SquadMS\Foundation;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\View\ComponentAttributeBag;
use Illuminate\Console\Scheduling\Schedule;
use SquadMS\Foundation\Facades\SquadMSAdminMenu;
use SquadMS\Foundation\Facades\SquadMSMenu;
use SquadMS\Foundation\Helpers\NavigationHelper;
use SquadMS\Foundation\Jobs\FetchUsers;
use SquadMS\Foundation\Menu\SquadMSMenuEntry;
use SquadMS\Foundation\Menu\SquadMSMenuHTMLEntry;
use SquadMS\Foundation\Modularity\Contracts\SquadMSModule as SquadMSModuleContract;

class SquadMSModule extends SquadMSModuleContract {
    static function getIdentifier() : string
    {
        return 'sqms-foundation';
    }

    static function getName() : string
    {
        return 'SquadMS Foundation';
    }

    static function publishAssets() : void
    {
        Artisan::call('vendor:publish', [
            '--provider' => SquadMSFoundationServiceProvider::class,
            '--tag'     => 'assets',
            '--force'  => true,
        ]);
    }

    static function registerAdminMenus() : void
    {
        SquadMSAdminMenu::register('admin', 0);
        SquadMSAdminMenu::register('admin-system', PHP_INT_MAX);
    }

    static function registerMenuEntries(string $menu) : void
    {
        switch ($menu) {
            case 'main-left':
                SquadMSMenu::register(
                    'main-left',
                    (new SquadMSMenuEntry(Config::get('sqms.routes.def.home.name'), fn () => __('sqms-foundation::navigation.home'), true))
                    ->setActive( fn (SquadMSMenuEntry $link) => NavigationHelper::isCurrentRoute(Config::get('sqms.routes.def.home.name')) )
                    ->setOrder(100)
                );

                SquadMSMenu::register(
                    'main-left',
                    (new SquadMSMenuEntry(Config::get('sqms.routes.def.admin-dashboard.name'), fn () => __('sqms-foundation::navigation.admin'), true))
                    ->setCondition(Config::get('sqms.permissions.module') . ' admin')
                    ->setOrder(PHP_INT_MAX) // Always last item
                );
                break;

            case 'main-right':
                SquadMSMenu::register(
                    'main-right',
                    (new SquadMSMenuEntry(Config::get('sqms.routes.def.profile.name'), fn () => __('sqms-foundation::navigation.profile'), true, function () {
                        return ['steam_id_64' => Auth::user()->steam_id_64];
                    }))
                    ->setCondition(fn () => Auth::check())
                    ->setActive(fn () => NavigationHelper::isCurrentRoute(Config::get('sqms.routes.def.profile.name')) && Request::route('steam_id_64') === Auth::user()->steam_id_64)
                    ->setOrder(100)
                );
        
                SquadMSMenu::register(
                    'main-right',
                    (new SquadMSMenuHTMLEntry(fn () => view(Config::get('sqms.theme') . '::' . Config::get('sqms.menu.entry-view'), [
                            'attributes' => new ComponentAttributeBag([
                                'onclick' => 'event.preventDefault(); document.getElementById(\'frm-logout\').submit();'
                            ]),
                            'link'   => route(Config::get('sqms.routes.def.logout.name')),
                            'title'  => __('sqms-foundation::navigation.logout'),
                            'slot'   => '<form id="frm-logout" action="'.route(Config::get('sqms.routes.def.logout.name')).'" method="POST" style="display: none;">'.csrf_field().'</form>'
                        ])->render()
                    ))
                    ->setCondition(fn () => Auth::check())
                    ->setOrder(200)
                );
        
                SquadMSMenu::register(
                    'main-right',
                    (new SquadMSMenuEntry(Config::get('sqms.routes.def.steam-login.name'), fn () => __('sqms-foundation::navigation.login'), true))
                    ->setCondition(fn () => !Auth::check())
                    ->setOrder(100)
                );

                break;

            case 'admin':
                SquadMSMenu::register(
                    'admin',
                    (new SquadMSMenuEntry(Config::get('sqms.routes.def.admin-dashboard.name'), '<i class="bi bi-house-fill"></i> Dashboard', true))->setView('sqms-foundation::components.navigation.item')
                    ->setActive( fn (SquadMSMenuEntry $link) => NavigationHelper::isCurrentRoute(Config::get('sqms.routes.def.admin-dashboard.name')) )
                    ->setOrder(100)
                );

                break;

            case 'admin-system':
                SquadMSMenu::prepend('admin-system', fn () => view('sqms-foundation::components.navigation.heading', [
                    'title'  => 'System',
                ])->render());

                SquadMSMenu::register(
                    'admin-system',
                    (new SquadMSMenuEntry(Config::get('sqms.routes.def.admin-rbac.name'), '<i class="bi bi-shield-lock-fill"></i> RBAC', true))->setView('sqms-foundation::components.navigation.item')
                    ->setActive( fn (SquadMSMenuEntry $link) => NavigationHelper::isCurrentRoute(Config::get('sqms.routes.def.admin-rbac.name')) )
                    ->setCondition(Config::get('sqms.permissions.module') . ' admin rbac')
                    ->setOrder(100)
                );

                break;
        }
    }

    static function schedule(Schedule $schedule) : void
    {
        /* Fetch unfetched or outdated users */
        $schedule->job(new FetchUsers())->withoutOverlapping()->everyFiveMinutes();
    }
}