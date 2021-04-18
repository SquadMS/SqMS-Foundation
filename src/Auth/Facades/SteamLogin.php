<?php

namespace SquadMS\Foundation\Auth\Facades;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Facade;
use SquadMS\Foundation\Auth\Http\Controllers\SteamLoginController;

class SteamLogin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \SquadMS\Foundation\Auth\SteamLogin::class;
    }
}