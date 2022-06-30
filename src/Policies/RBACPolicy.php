<?php

namespace SquadMS\Foundation\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Role;
use SquadMS\Foundation\Models\SquadMSUser;

class RBACPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \SquadMS\Foundation\Models\SquadMSUser; $user
     * @return mixed
     */
    public function viewAny(SquadMSUser $user)
    {
        return $user->can(Config::get('sqms.permissions.module').' admin rbac');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \SquadMS\Foundation\Models\SquadMSUser; $user
     * @param  \Spatie\Permission\Models\Role  $role
     * @return mixed
     */
    public function view(SquadMSUser $user, Role $role)
    {
        return $user->can(Config::get('sqms.permissions.module').' admin rbac');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \SquadMS\Foundation\Models\SquadMSUser; $user
     * @return mixed
     */
    public function create(SquadMSUser $user)
    {
        return $user->can(Config::get('sqms.permissions.module').' admin rbac');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \SquadMS\Foundation\Models\SquadMSUser; $user
     * @param  \Spatie\Permission\Models\Role  $role
     * @return mixed
     */
    public function update(SquadMSUser $user, Role $role)
    {
        return $user->can(Config::get('sqms.permissions.module').' admin rbac');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \SquadMS\Foundation\Models\SquadMSUser; $user
     * @param  \Spatie\Permission\Models\Role  $role
     * @return mixed
     */
    public function delete(SquadMSUser $user, Role $role)
    {
        return $user->can(Config::get('sqms.permissions.module').' admin rbac');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \SquadMS\Foundation\Models\SquadMSUser; $user
     * @param  \Spatie\Permission\Models\Role  $role
     * @return mixed
     */
    public function restore(SquadMSUser $user, Role $role)
    {
        return $user->can(Config::get('sqms.permissions.module').' admin rbac');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \SquadMS\Foundation\Models\SquadMSUser; $user
     * @param  \Spatie\Permission\Models\Role  $role
     * @return mixed
     */
    public function forceDelete(SquadMSUser $user, Role $role)
    {
        return $user->can(Config::get('sqms.permissions.module').' admin rbac');
    }
}
