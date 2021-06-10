<?php

namespace SquadMS\Foundation\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use SquadMS\Foundation\Facades\SquadMSPermissions as FacadesSquadMSPermissions;
use SquadMS\Foundation\SquadMSPermissions;

class PermissionsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SquadMSPermissions::class, function () {
            return new SquadMSPermissions();
        });
    }

    public function boot()
    {
        /* Permissions */
        foreach (Config::get('sqms.permissions.definitions', []) as $definition => $displayName) {
            FacadesSquadMSPermissions::define(Config::get('sqms.permissions.module'), $definition, $displayName);
        }

        // Implicitly grant system admins all permissions
        Gate::before(function ($user, $ability) {
            return $user->isSystemAdmin() ? true : null;
        });
    }
}
