<?php

namespace SquadMS\Foundation\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class UserHelper
{
    /**
     * Get the User model instance
     */
    public static function getUserModel() : Model
    {
        $model = Config::get('sqms.user.model');
        return new $model();
    }

    /**
     * Check if the given object is the User model.
     */
    public static function checkUserModel(Model $user) : void
    {
        if (get_class($user) !== Config::get('sqms.user.model')) {
            throw new \InvalidArgumentException('$user must be of type ' . Config::get('sqms.user.model'));
        }
    }
}