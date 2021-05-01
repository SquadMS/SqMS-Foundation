<?php

namespace SquadMS\Foundation\Auth\Http\Controllers;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use SquadMS\Foundation\Auth\Contracts\SteamLoginControllerInterface;
use SquadMS\Foundation\Auth\SteamLogin;

abstract class AbstractSteamLoginController extends Controller implements SteamLoginControllerInterface
{
    /**
     * SteamLogin instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * SteamLogin instance.
     *
     * @var \SquadMS\Foundation\Auth\SteamLogin
     */
    protected $steam;

    /**
     * AbstractSteamLoginController constructor.
     *
     * @param \Illuminate\Http\Request            $request
     * @param \SquadMS\Foundation\Auth\SteamLogin $steam
     */
    public function __construct(Request $request, SteamLogin $steam)
    {
        $this->request = $request;
        $this->steam = $steam;
    }

    /**
     * Redirect to steam login page or maybe show a login page if overridden.
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        return $this->redirectToSteam($request);
    }

    /**
     * {@inheritdoc}
     */
    public function redirectToSteam(Request $request): RedirectResponse
    {
        return $this->steam->redirectToSteam($request);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function authenticate(Request $request)
    {
        if ($steamUser = $this->steam->validated($request)) {
            $result = $this->authenticated($this->request, $steamUser);

            if (!empty($result)) {
                return $result;
            }
        } else {
            throw new Exception('Steam Login failed.');
        }

        return $this->steam->previousPage($request);
    }
}