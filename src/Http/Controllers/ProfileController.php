<?php

namespace SquadMS\Foundation\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use SquadMS\Foundation\Models\SquadMSUser;

class ProfileController extends Controller
{
    use AuthorizesRequests;

    /**
     * Shows the profile page.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(string $steamId64)
    {
        /** @var \App\Models\User Find user given steamId64 */
        $user = SquadMSUser::where('steam_id_64', $steamId64)->firstOrFail();

        /* Show profile page */
        return view('sqms-foundation::profile', [
            'user' => $user,
        ]);
    }

    /**
     * Shows the profile page.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings(string $steamId64)
    {
        /** @var \App\Models\User Find user given steamId64 */
        $user = SquadMSUser::where('steam_id_64', $steamId64)->firstOrFail();

        /* Check if the current User can edit the settings of the retrieved User */
        $this->authorize('editSettings', $user);

        /* Show profile page */
        return view('sqms-foundation::profile-settings', [
            'user' => $user,
        ]);
    }
}
