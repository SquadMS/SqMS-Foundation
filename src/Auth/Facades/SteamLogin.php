<?php

namespace SquadMS\Foundation\Auth\Facades;

use Illuminate\Support\Facades\Facade;

class SteamLogin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \SquadMS\Foundation\Auth\SteamLogin::class;
    }
}
