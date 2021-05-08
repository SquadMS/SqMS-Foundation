<?php

namespace SquadMS\Foundation\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use SquadMS\Foundation\SquadMSPermissions;

class PermissionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(SquadMSPermissions::class, function () {
            return new SquadMSPermissions();
        });
    }

    public function register()
    {
        /* Permissions */
        foreach (Config::get('sqms.permissions.definitions') as $definition => $displayName) {
            SquadMSPermissions::getInstance()->define(Config::get('sqms.permissions.module'), $definition, $displayName);
        }

        // Implicitly grant system admins all permissions
        Gate::before(function ($user, $ability) {
            return $user->isSystemAdmin() ? true : null;
        });
    }
}