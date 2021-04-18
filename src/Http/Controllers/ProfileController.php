<?php

namespace SquadMS\Foundation\Http\Controllers;

use Illuminate\Routing\Controller;
use SquadMS\Foundation\Models\User;

class ProfileController extends Controller
{
    /**
     * Shows the profile page
     *
     * @return \Illuminate\Http\Response
     */
    public function show(string $steamId64)
    {
        /** @var \SquadMS\Foundation\Models\User Find user given steamId64 */
        $user = User::where('steam_id_64', $steamId64)->firstOrFail();

        /* Show profile page */
        return view('squadms-foundation::pages.profile.index', [
            'user' => $user,
        ]);
    }
}