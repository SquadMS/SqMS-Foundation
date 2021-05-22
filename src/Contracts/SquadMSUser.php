<?php

namespace SquadMS\Foundation\Contracts;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

abstract class SquadMSUser extends Authenticatable
{
    use HasRoles;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /* Disable Laravel's mass assignment protection */
    protected $guarded = [
        //
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'api_token',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'last_fetched' => 'datetime',
    ];

    public function isSystemAdmin() : bool
    {
        return in_array($this->steam_id_64, config('sqms.admins'));
    }

    /**
     * Helper to retrieve the current user or null.
     *
     * @return null|self
     */
    public abstract function current() : ?self;
}