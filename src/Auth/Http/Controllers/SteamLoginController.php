<?php

namespace SquadMS\Foundation\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use SquadMS\Foundation\Auth\SteamUser;
use SquadMS\Foundation\Repositories\UserRepository;

class SteamLoginController extends AbstractSteamLoginController
{
    /**
     * Called when the request is successfully authenticated.
     *
     * @param \Illuminate\Http\Request               $request
     * @param \SquadMS\Foundation\Auth\SteamUser $steamUser
     *
     * @return mixed|void
     */
    public function authenticated(Request $request, SteamUser $steamUser)
    {
        /* Create or Update user, fetch data from SteamAPI */
        $user = UserRepository::createOrUpdate($steamUser);

        /* Login the user using the Auth facade */
        Auth::login($user, true);

        /* Set the api_token (if none is set) */
        if (!$user->api_token) {
            $user->update([
                'api_token' => Str::random(60),
            ]);
        }

        return redirect(route('profile', [
            'steam_id_64' => $steamUser->steamId
        ]));
    }
}