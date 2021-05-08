<?php

namespace SquadMS\Foundation\Auth\Contracts;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use SquadMS\Foundation\Auth\SteamUser;

interface SteamLoginControllerInterface
{
    /**
     * Redirect to steam login page or maybe show a login page if overridden.
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request): RedirectResponse;

    /**
     * Logout the current user and redirect to the configured home route.
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse;
    
    /**
     * Redirect the user to the Steam login page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToSteam(Request $request): RedirectResponse;

    /**
     * Authenticate the incoming request.
     * 
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function authenticate(Request $request);

    /**
     * Called when the request is successfully authenticated.
     *
     * @param \Illuminate\Http\Request               $request
     * @param \SquadMS\Foundation\Auth\SteamUser $steamUser
     *
     * @return void
     */
    public function authenticated(Request $request, SteamUser $steamUser) : void;
}