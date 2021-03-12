<?php

namespace SquadMS\Foundation\Helpers;

use Illuminate\Database\Eloquent\Model;

class UserHelper
{
    /**
     * Get the User model instance
     */
    public static function getUserModel() : Model
    {
        $model = config('auth.providers.users.model');
        return new $model();
    }

    /**
     * Check if the given object is the User model.
     */
    public static function checkUserModel(Model $user) : void
    {
        if (get_class($user) !== config('auth.providers.users.model')) {
            throw new \InvalidArgumentException('$user must be of type ' . config('auth.providers.users.model'));
        }
    }
}