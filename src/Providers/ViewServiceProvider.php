<?php

namespace SquadMS\Foundation\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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

        Blade::directive('wat', function ($expression) {
            $wat = '';
            if (Auth::user()) {
                if (($t = Auth::user()->getCurrentWebSocketToken())) {
                    $wat = $t->token;
                }
            }
            return '<meta name="wat" content="{{ $wat }}">';
        });
    }
}
