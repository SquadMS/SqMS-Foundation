<?php

namespace SquadMS\Foundation\Auth\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use SquadMS\Foundation\Auth\Contracts\SteamLoginControllerInterface;
use SquadMS\Foundation\Auth\SteamLogin;
use SquadMS\Foundation\Models\SquadMSUser;

abstract class AbstractSteamLoginController extends Controller implements SteamLoginControllerInterface
{
    use AuthorizesRequests;

    protected Request $request;

    protected SteamLogin $steam;

    /**
     * AbstractSteamLoginController constructor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \SquadMS\Foundation\Auth\SteamLogin  $steam
     */
    public function __construct(Request $request, SteamLogin $steam)
    {
        $this->request = $request;
        $this->steam = $steam;
    }

    /**
     * @inheritdoc
     */
    public function login(Request $request): RedirectResponse
    {
        return $this->redirectToSteam($request);
    }

    /**
     * @inheritdoc
     */
    public function logout(Request $request): RedirectResponse
    {
        /* Get the current user and session id */
        $user = SquadMSUser::current();
        $sessionId = $request->session()->getId();

        /* Logout the User */
        Auth::logout();

        /* Actively delete the session record */
        $user->deleteSessionRecord($sessionId);

        if (Config::get('sqms.auth.redirect', 0) >= 1) {
            return redirect(URL::previous());
        } else {
            return redirect(route(Config::get('sqms.routes.def.home.name'), [], true, App::getLocale()));
        }
    }

    /**
     * Logs out the current users other devices while leaving the current session untouched.
     *
     * @return \Illuminate\Http\Response
     */
    public function logoutOtherDevices()
    {
        /* Log out the current users other devices using the default password */
        Auth::logoutOtherDevices(Config::get('sqms.user.default-password', 'DefaultUserPassword'));

        /* Delete all other session records from DB other than this one */
        SquadMSUser::current()->deleteOtherSessionRecords();

        /* Go back to where we came from */
        return redirect()->back()->withSuccess('Successfully logged out other sessions!');
    }

    /**
     * @inheritdoc
     */
    public function redirectToSteam(Request $request): RedirectResponse
    {
        /* Redirect to Home on default */
        $redirectTo = route(Config::get('sqms.routes.def.home.name'), [], true, App::getLocale());

        switch (Config::get('sqms.auth.redirect', 0)) {
            case 1: // Previous
                $redirectTo = URL::previous();
                break;
            case 2: // Profile
                $redirectTo = 'profile';
                break;
        }

        return $this->steam->redirectToSteam($request, $redirectTo);
    }

    /**
     * @inheritdoc
     *
     * @throws \Exception
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $locale = $request->get('lang', Config::get('app.locale', 'en'));

        if ($steamUser = $this->steam->validated($request)) {
            $this->authenticated($this->request, $steamUser);

            if ($request->has('redirect')) {
                if ($request->get('redirect') === 'profile') {
                    return redirect(route('profile', [
                        'steam_id_64' => $steamUser->steamId,
                    ], true, $locale));
                } else {
                    $t = $request->get('redirect');

                    return redirect($request->get('redirect'));
                }
            } else {
                return redirect(route(Config::get('sqms.routes.def.home.name'), [], true, $locale));
            }
        } else {
            Log::error('Steam Login failed!');

            return redirect(route(Config::get('sqms.routes.def.home.name'), [], true, $locale))->withErrors('Steam Login failed.');
        }
    }
}
