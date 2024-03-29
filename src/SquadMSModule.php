<?php

namespace SquadMS\Foundation;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\View\ComponentAttributeBag;
use SquadMS\Foundation\Facades\SquadMSMenu;
use SquadMS\Foundation\Helpers\NavigationHelper;
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
            '--tag'      => self::getIdentifier().'-assets',
            '--force'    => true,
        ]);
    }

    public static function registerMenuEntries(string $menu): void
    {
        switch ($menu) {
            case 'main':
                SquadMSMenu::register(
                    'main',
                    (new SquadMSMenuEntry(Config::get('sqms.routes.def.home.name'), fn () => __('sqms-foundation::navigation.home'), true))
                    ->setActive(fn (SquadMSMenuEntry $link) => NavigationHelper::isCurrentRoute(Config::get('sqms.routes.def.home.name')))
                    ->setOrder(100)
                );

                SquadMSMenu::register(
                    'main',
                    (new SquadMSMenuEntry(Config::get('sqms.routes.def.profile.name'), fn () => __('sqms-foundation::navigation.profile'), true, function () {
                        return ['steam_id_64' => Auth::user()->steam_id_64];
                    }))
                    ->setCondition(fn () => Auth::check())
                    ->setActive(fn () => NavigationHelper::isCurrentRoute(Config::get('sqms.routes.def.profile.name')) && Request::route('steam_id_64') === Auth::user()->steam_id_64)
                    ->setOrder(300)
                );

                SquadMSMenu::register(
                    'main',
                    (new SquadMSMenuHTMLEntry(
                        fn () => view('sqms-foundation::components.navigation.item', [
                            'attributes' => new ComponentAttributeBag([
                                'onclick' => 'event.preventDefault(); document.getElementById(\'frm-logout\').submit();',
                            ]),
                            'link'   => route(Config::get('sqms.routes.def.logout.name')),
                            'title'  => __('sqms-foundation::navigation.logout'),
                            'slot'   => '<form id="frm-logout" action="'.route(Config::get('sqms.routes.def.logout.name')).'" method="POST" style="display: none;">'.csrf_field().'</form>',
                        ])->render()
                    ))
                    ->setCondition(fn () => Auth::check())
                    ->setOrder(PHP_INT_MAX - 1)
                );

                SquadMSMenu::register(
                    'main',
                    (new SquadMSMenuEntry(Config::get('sqms.routes.def.steam-login.name'), fn () => __('sqms-foundation::navigation.login'), true))
                    ->setCondition(fn () => ! Auth::check())
                    ->setOrder(PHP_INT_MAX - 1)
                );

                SquadMSMenu::register(
                    'main',
                    (new SquadMSMenuEntry('filament.pages.dashboard', fn () => __('sqms-foundation::navigation.admin'), true))
                    ->setCondition(Config::get('sqms.permissions.module').' admin')
                    ->setOrder(PHP_INT_MAX) // Always last item
                );

                break;
        }
    }
}
