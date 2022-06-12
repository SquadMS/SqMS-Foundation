<?php

return [
    'theme' => env('SQUADMS_THEME', 'sqms-default-theme'),

    'admins' => [
        // List of SteamID64s
    ],

    'user' => [
        'model'            => \SquadMS\Foundation\Models\SquadMSUser::class,
        'default-password' => 'DefaultUserPasswordNotBeingUsedForLoginSinceWeUseSteamWeUseThisForLogginOutOtherSessionsForExample',
        'fetch_interval'   => 12,
        'defaults'         => [
            'name'   => 'No Username :(',
            'avatar' => [
                'full'   => '/images/avatar.jpg',
                'medium' => '/images/avatar_medium.jpg',
                'small'  => '/images/avatar_small.jpg',
            ],
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
        'prefix'     => null,
        'middleware' => ['web'],
        'def'        => [
            'home' => [
                'type'        => 'get',
                'name'        => 'home',
                'path'        => '/',
                'middlewares' => [],
                'controller'  => \SquadMS\Foundation\Http\Controllers\HomeController::class,
                'executor'    => 'show',
                'localized'   => true,
            ],
            'profile' => [
                'type'        => 'get',
                'name'        => 'profile',
                'path'        => 'profile/{steam_id_64}',
                'middlewares' => [],
                'controller'  => \SquadMS\Foundation\Http\Controllers\ProfileController::class,
                'executor'    => 'show',
                'localized'   => true,
            ],
            'profile-settings' => [
                'type'        => 'get',
                'name'        => 'profile-settings',
                'path'        => 'profile/{steam_id_64}/settings',
                'middlewares' => ['auth'],
                'controller'  => \SquadMS\Foundation\Http\Controllers\ProfileController::class,
                'executor'    => 'settings',
                'localized'   => true,
            ],
            'steam-login' => [
                'type'        => 'get',
                'name'        => 'steam.login',
                'path'        => 'steam/login',
                'middlewares' => ['guest'],
                'controller'  => \SquadMS\Foundation\Auth\Http\Controllers\SteamLoginController::class,
                'executor'    => 'login',
                'localized'   => true,
            ],
            'steam-auth' => [
                'type'        => 'get',
                'name'        => 'steam.auth',
                'path'        => 'steam/auth',
                'middlewares' => ['guest'],
                'controller'  => \SquadMS\Foundation\Auth\Http\Controllers\SteamLoginController::class,
                'executor'    => 'authenticate',
                'localized'   => false,
            ],
            'logout' => [
                'type'        => 'post',
                'name'        => 'logout',
                'path'        => 'logout',
                'middlewares' => ['auth'],
                'controller'  => \SquadMS\Foundation\Auth\Http\Controllers\SteamLoginController::class,
                'executor'    => 'logout',
                'localized'   => true,
            ],
            'logoutOtherDevices' => [
                'type'        => 'post',
                'name'        => 'logoutOtherDevices',
                'path'        => 'logoutOtherDevices',
                'middlewares' => ['auth'],
                'controller'  => \SquadMS\Foundation\Auth\Http\Controllers\SteamLoginController::class,
                'executor'    => 'logoutOtherDevices',
                'localized'   => true,
            ],
        ],
    ],

    'menu' => [
        'activeClassOnLink' => true,
        'entry-view'        => 'components.navigation.item',
    ],

    'permissions' => [
        'module'      => 'sqms',
        'definitions' => [
            'admin'                    => 'Grant access to the AdminCP',
            'admin rbac'               => 'Grant access to the RBAC Management',
            'admin profile-moderation' => 'Grant access to other Users Profile-Settings',
        ],
    ],

    'sdkdata' => [
        'data-url' => 'https://raw.githubusercontent.com/Squad-Wiki-Editorial/squad-wiki-pipeline-map-data/master/completed_output/_Current%20Version/finished.json',
    ],
    
    'locales' => [
        'enabled' => explode(',', env('SQMS_LANGUAGES', implode(',', config('sqms,locales.supported')))),
        'supported' => [
            'en',
            'de',
            'ar',
            'he',
        ]
    ]
    
    'config-overrides' => [
        'filament' => [
            'dark_mode' => true,
            'auth' => [
                'pages' => [
                    'login' => \SquadMS\Foundation\Http\Livewire\Auth\Login::class,
                ],
            ],
        ],
        'filament-spatie-laravel-translatable-plugin' => [
            'default_locales' => config('sqms.locales.enabled'),
        ],
        'localized-routes' => [
            'supported-locales' => config('sqms.locales.enabled'),
            'omit_url_prefix_for_locale' => config('app.locale'),
        ]
    ],
];
