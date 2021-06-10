<?php

namespace SquadMS\Foundation\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Role;
use SquadMS\Foundation\Policies\RBACPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Role::class => RBACPolicy::class,
    ];

    public function register()
    {
        //
    }

    public function boot()
    {
        /* Permissions */
        $this->registerPolicies();
    }
}
