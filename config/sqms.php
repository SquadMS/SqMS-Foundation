<?php

return [
    'admins' => [
        // List of SteamID64s
    ],
    'user' => [
        'model' => \App\Models\User::class,
        'fetch_interval' => 12,
        'defaults' => [
            'name' => 'No Username :(',
            'avatar' => [
                'full' => '/images/avatar.jpg',
                'medium' => '/images/avatar_medium.jpg',
                'small' => '/images/avatar_small.jpg',
            ]
        ],
    ],

    'auth' => [
        'redirect' => 0, // 0 = Redirect Home, 1 = Redirect previous page, 3 = Redirect Profile

        'controller' => \SquadMS\Foundation\Auth\Http\Controllers\SteamLoginController::class,

        'api_key' => env('STEAM_API_KEY'),

        /*
         * Method of retrieving player's profile data.
         * Valid options: xml, api
         */
        'method'  => env('STEAM_LOGIN_PROFILE_DATA_METHOD', env('STEAM_LOGIN_PROFILE_METHOD', 'api')),

        'timeout' => env('STEAM_LOGIN_TIMEOUT', 5),
    ],

    'routes' => [
        'prefix' => null,
        'middleware' => ['web'],
        'def' => [
            'home' => [
                'type' => 'get',
                'name' => 'home',
                'path' => '/',
                'middlewares' => [],
                'controller' => \SquadMS\Foundation\Http\Controllers\HomeController::class,
                'executor' => 'show',
                'localized' => true,
            ],
            'profile' => [
                'type' => 'get',
                'name' => 'profile',
                'path' => 'profile/{steam_id_64}',
                'middlewares' => [],
                'controller' => \SquadMS\Foundation\Http\Controllers\ProfileController::class,
                'executor' => 'show',
                'localized' => true,
            ],
            'admin-dashboard' => [
                'type' => 'get',
                'name' => 'admin.dashboard',
                'path' => 'admin/dashboard',
                'middlewares' => ['auth', 'checkAdminAreaAccess'],
                'controller' => \SquadMS\Foundation\Admin\Http\Controllers\DashboardController::class,
                'executor' => 'show',
                'localized' => false,
            ],
            'steam-login' => [
                'type' => 'get',
                'name' => 'steam.login',
                'path' => 'steam/login',
                'middlewares' => ['guest'],
                'controller' => \SquadMS\Foundation\Auth\Http\Controllers\SteamLoginController::class,
                'executor' => 'login',
                'localized' => true,
            ],
            'steam-auth' => [
                'type' => 'get',
                'name' => 'steam.auth',
                'path' => 'steam/auth',
                'middlewares' => ['guest'],
                'controller' => \SquadMS\Foundation\Auth\Http\Controllers\SteamLoginController::class,
                'executor' => 'authenticate',
                'localized' => false,
            ],
            'logout' => [
                'type' => 'post',
                'name' => 'logout',
                'path' => 'logout',
                'middlewares' => ['auth'],
                'controller' => \SquadMS\Foundation\Auth\Http\Controllers\SteamLoginController::class,
                'executor' => 'logout',
                'localized' => true,
            ]
        ]
    ],

    'theme' => env('SQUADMS_THEME', 'squadms-default-theme')
];