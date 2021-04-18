<?php

namespace SquadMS\Foundation\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use SquadMS\Foundation\Repositories\UserRepository;

class ProfileController extends Controller
{
    /**
     * Shows the profile page
     *
     * @return \Illuminate\Http\Response
     */
    public function show(string $steamId64)
    {
        /** @var \App\Models\User Find user given steamId64 */
        $user = UserRepository::getUserModelQuery()->where('steam_id_64', $steamId64)->firstOrFail();

        /* Show profile page */
        return view(Config::get('sqms.theme') . '::pages.profile', [
            'user' => $user,
        ]);
    }
}