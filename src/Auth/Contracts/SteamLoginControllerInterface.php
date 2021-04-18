
<?php

namespace SquadMS\Foundation\Auth\Contracts;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use SquadMS\Foundation\Auth\SteamUser;

interface SteamLoginControllerInterface
{
    /**
     * Redirect the user to the Steam login page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToSteam(): RedirectResponse;

    /**
     * Authenticate the incoming request.
     *
     * @return mixed
     */
    public function authenticate();

    /**
     * Called when the request is successfully authenticated.
     *
     * @param \Illuminate\Http\Request               $request
     * @param \SquadMS\Foundation\Auth\SteamUser $steamUser
     *
     * @return mixed|void
     */
    public function authenticated(Request $request, SteamUser $steamUser);
}