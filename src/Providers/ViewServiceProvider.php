<?php

namespace SquadMS\Foundation\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use SquadMS\Foundation\Contracts\SquadMSUser;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /* Load views */
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'sqms-foundation');

        /* Add isAdmin directive */
        Blade::if('admin', function ($user) {
            return $user && ($user->isSystemAdmin() || $user->can('admin'));
        });

        Blade::directive('websocketToken', function ($expression) {
            $wat = '';
            if (($user = SquadMSUser::current())) {
                if (($t = $user->getCurrentWebSocketToken())) {
                    $wat = $t->token;
                }
            }
            return '<meta name="wat" content="' . $wat . '">';
        });
    }
}
