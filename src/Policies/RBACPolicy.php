<?php

namespace SquadMS\Foundation\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;
use SquadMS\Foundation\Contracts\SquadMSUser;

class RBACPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \SquadMS\Foundation\Contracts\SquadMSUser;  $user
     * @return mixed
     */
    public function viewAny(SquadMSUser $user)
    {
        return $user->can('admin rbac');    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \SquadMS\Foundation\Contracts\SquadMSUser;  $user
     * @param  \Spatie\Permission\Models\Role  $role
     * @return mixed
     */
    public function view(SquadMSUser $user, Role $role)
    {
        return $user->can('admin rbac');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \SquadMS\Foundation\Contracts\SquadMSUser;  $user
     * @return mixed
     */
    public function create(SquadMSUser $user)
    {
        return $user->can('admin rbac');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \SquadMS\Foundation\Contracts\SquadMSUser;  $user
     * @param  \Spatie\Permission\Models\Role  $role
     * @return mixed
     */
    public function update(SquadMSUser $user, Role $role)
    {
        return $user->can('admin rbac');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \SquadMS\Foundation\Contracts\SquadMSUser;  $user
     * @param  \Spatie\Permission\Models\Role  $role
     * @return mixed
     */
    public function delete(SquadMSUser $user, Role $role)
    {
        return $user->can('admin rbac');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \SquadMS\Foundation\Contracts\SquadMSUser;  $user
     * @param  \Spatie\Permission\Models\Role  $role
     * @return mixed
     */
    public function restore(SquadMSUser $user, Role $role)
    {
        return $user->can('admin rbac');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \SquadMS\Foundation\Contracts\SquadMSUser;  $user
     * @param  \Spatie\Permission\Models\Role  $role
     * @return mixed
     */
    public function forceDelete(SquadMSUser $user, Role $role)
    {
        return $user->can('admin rbac');
    }
}
