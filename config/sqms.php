<?php

return [
    'user' => [
        'model' => \App\Models\User::class,
        'route' => [
            'name' => 'profile',
            'url'  => 'profile',
            'controller' => \SquadMS\Foundation\Http\Controllers\ProfileController::class,
        ],
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
        'controller' => \SquadMS\Foundation\Auth\Http\Controllers\SteamLoginController::class,

        'api_key' => env('STEAM_API_KEY'),

        /*
         * Method of retrieving player's profile data.
         * Valid options: xml, api
         */
        'method'  => env('STEAM_LOGIN_PROFILE_DATA_METHOD', env('STEAM_LOGIN_PROFILE_METHOD', 'api')),

        'timeout' => env('STEAM_LOGIN_TIMEOUT', 5),

        'routes'  => [
            'login'    => env('STEAM_LOGIN_ROUTE', env('STEAM_LOGIN_ROUTE_NAME', 'steam.login')),
            'auth'     => env('STEAM_LOGIN_AUTH_ROUTE', env('STEAM_AUTH_ROUTE_NAME', 'steam.auth')),
            'redirect' => env('STEAM_LOGIN_REDIRECT_ROUTE', env('STEAM_REDIRECT_ROUTE_NAME', 'profile')),
        ],
    ],

    'routes' => [
        
    ],

    'theme' => env('SQUADMS_THEME', 'squadms-default-theme')
];