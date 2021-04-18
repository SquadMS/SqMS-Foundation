<?php

namespace SquadMS\Foundation\Auth\Http\Controllers;

use Illuminate\Http\Request;
use SquadMS\Foundation\Auth\SteamUser;

/**
 * @deprecated
 */
class SteamLoginHandlerController extends AbstractSteamLoginController
{
    /**
     * {@inheritdoc}
     */
    public function authenticated(Request $request, SteamUser $steamUser)
    {
        // TODO: Implement authenticated() method.
    }
}