<?php

namespace SquadMS\Foundation\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Role;
use SquadMS\Foundation\SquadMS\Foundation\Models\SquadMSUser;
use SquadMS\Foundation\Policies\RBACPolicy;
use SquadMS\Foundation\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        /* Permissions */
        $this->registerPolicies();
    }

    /**
     * The policy mappings for the application.
     *
     * @return array
     */
    public function policies()
    {
        return [
            Role::class => RBACPolicy::class,
            Config::get('sqms.user.model') => UserPolicy::class,
        ];
    }
}
