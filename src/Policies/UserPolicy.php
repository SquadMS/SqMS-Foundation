<?php

namespace SquadMS\Foundation\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Role;
use SquadMS\Foundation\Contracts\SquadMSUser;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \SquadMS\Foundation\Contracts\SquadMSUser  $user
     *
     * @return mixed
     */
    public function viewAny(SquadMSUser $user)
    {
        return $user->can(Config::get('sqms.permissions.module') .  ' admin');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \SquadMS\Foundation\Contracts\SquadMSUser  $user
     * @param \SquadMS\Foundation\Contracts\SquadMSUser  $subject
     *
     * @return mixed
     */
    public function view(SquadMSUser $user, SquadMSUser $subject)
    {
        return $user->id === $subject->id || $user->can(Config::get('sqms.permissions.module') .  ' admin');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \SquadMS\Foundation\Contracts\SquadMSUser  $user
     *
     * @return mixed
     */
    public function create(SquadMSUser $user)
    {
        return $user->can(Config::get('sqms.permissions.module') .  ' admin');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \SquadMS\Foundation\Contracts\SquadMSUser  $user
     * @param \SquadMS\Foundation\Contracts\SquadMSUser  $subject
     *
     * @return mixed
     */
    public function update(SquadMSUser $user, SquadMSUser $subject)
    {
        return $user->id === $subject->id || $user->can(Config::get('sqms.permissions.module') .  ' admin');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \SquadMS\Foundation\Contracts\SquadMSUser  $user
     * @param \SquadMS\Foundation\Contracts\SquadMSUser  $subject
     *
     * @return mixed
     */
    public function delete(SquadMSUser $user, SquadMSUser $subject)
    {
        return $user->id === $subject->id || $user->can(Config::get('sqms.permissions.module') .  ' admin');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \SquadMS\Foundation\Contracts\SquadMSUser  $user
     * @param \SquadMS\Foundation\Contracts\SquadMSUser  $subject
     *
     * @return mixed
     */
    public function restore(SquadMSUser $user, SquadMSUser $subject)
    {
        return $user->id === $subject->id || $user->can(Config::get('sqms.permissions.module') .  ' admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \SquadMS\Foundation\Contracts\SquadMSUser  $user
     * @param \SquadMS\Foundation\Contracts\SquadMSUser  $subject
     *
     * @return mixed
     */
    public function forceDelete(SquadMSUser $user, SquadMSUser $subject)
    {
        return $user->id === $subject->id || $user->can(Config::get('sqms.permissions.module') .  ' admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \SquadMS\Foundation\Contracts\SquadMSUser  $user
     * @param \SquadMS\Foundation\Contracts\SquadMSUser  $subject
     *
     * @return mixed
     */
    public function editSettings(SquadMSUser $user, SquadMSUser $subject)
    {
        return $user->id === $subject->id || $user->can(Config::get('sqms.permissions.module') .  ' admin profile-moderation');
    }
}
