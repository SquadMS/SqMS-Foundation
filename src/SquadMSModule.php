<?php

namespace SquadMS\Foundation;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\View\ComponentAttributeBag;
use SquadMS\Foundation\Facades\SquadMSMenu;
use SquadMS\Foundation\Helpers\NavigationHelper;
use SquadMS\Foundation\Jobs\FetchUsers;
use SquadMS\Foundation\Menu\SquadMSMenuEntry;
use SquadMS\Foundation\Menu\SquadMSMenuHTMLEntry;
use SquadMS\Foundation\Modularity\Contracts\SquadMSModule as SquadMSModuleContract;

class SquadMSModule extends SquadMSModuleContract
{
    public static function getIdentifier(): string
    {
        return 'sqms-foundation';
    }

    public static function getName(): string
    {
        return 'SquadMS Foundation';
    }

    public static function publishAssets(): void
    {
        Artisan::call('vendor:publish', [
            '--provider' => SquadMSFoundationServiceProvider::class,
            '--tag'      => 'assets',
            '--force'    => true,
        ]);
    }

    public static function registerMenuEntries(string $menu): void
    {
        switch ($menu) {
            case 'main-left':
                SquadMSMenu::register(
                    'main-left',
                    (new SquadMSMenuEntry(Config::get('sqms.routes.def.home.name'), fn () => __('sqms-foundation::navigation.home'), true))
                    ->setActive(fn (SquadMSMenuEntry $link) => NavigationHelper::isCurrentRoute(Config::get('sqms.routes.def.home.name')))
                    ->setOrder(100)
                );

                SquadMSMenu::register(
                    'main-left',
                    (new SquadMSMenuEntry('filament.pages.dashboard', fn () => __('sqms-foundation::navigation.admin'), true))
                    ->setCondition(Config::get('sqms.permissions.module').' admin')
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
                    (new SquadMSMenuHTMLEntry(
                        fn () => view(Config::get('sqms.theme').'::'.Config::get('sqms.menu.entry-view'), [
                            'attributes' => new ComponentAttributeBag([
                                'onclick' => 'event.preventDefault(); document.getElementById(\'frm-logout\').submit();',
                            ]),
                            'link'   => route(Config::get('sqms.routes.def.logout.name')),
                            'title'  => __('sqms-foundation::navigation.logout'),
                            'slot'   => '<form id="frm-logout" action="'.route(Config::get('sqms.routes.def.logout.name')).'" method="POST" style="display: none;">'.csrf_field().'</form>',
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
        }
    }

    public static function schedule(Schedule $schedule): void
    {
        /* Fetch unfetched or outdated users */
        $schedule->job(new FetchUsers())->withoutOverlapping()->everyFiveMinutes();
    }
}
