<?php

namespace SquadMS\Foundation\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use SquadMS\Foundation\Auth\SteamUser;
use SquadMS\Foundation\Repositories\UserRepository;

class SteamLoginController extends AbstractSteamLoginController
{
    /**
     * {@inheritdoc}
     */
    public function authenticated(Request $request, SteamUser $steamUser): void
    {
        /** @var \SquadMS\Foundation\Models\SquadMSUser Create or Update user, fetch data from SteamAPI */
        $user = UserRepository::createOrUpdate($steamUser);

        /* Login the user using the Auth facade */
        Auth::login($user, true);

        /* Make sure the session is being saved after login so we have an id to reference */
        Session::save();

        /* Create a new Websocket Token for the Session */
        $user->websocketTokens()->create([
            'token'      => Str::random(128),
            'session_id' => Session::getId(),
        ]);
    }
}
