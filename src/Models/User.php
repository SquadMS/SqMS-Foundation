<?php

namespace SquadMS\Foundation\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  // Disable Laravel's mass assignment protection
  protected $guarded = [];
}