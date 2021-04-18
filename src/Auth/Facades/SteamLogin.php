<?php

namespace SquadMS\Foundation\Auth\Facades;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Facade;
use SquadMS\Foundation\Auth\Http\Controllers\SteamLoginController;

class SteamLogin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \SquadMS\Foundation\Auth\SteamLogin::class;
    }

    public static function routes(array $options = [])
    {
        /* Merge options with defaults */
        $options = array_replace_recursive([
            'controller' => SteamLoginController::class,
            'login'      => 'login',
            'auth'       => 'authenticate',
        ], $options);

        /* Get the router */
        $router = App::make('router');

        /* Define the routes */
        $router->get('login/steam', [$options['controller'], $options['login']])->name('login.steam');
        $router->get('auth/steam', [$options['controller'], $options['auth']])->name('auth.steam');
    }
}