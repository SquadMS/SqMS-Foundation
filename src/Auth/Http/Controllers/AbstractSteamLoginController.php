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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(): RedirectResponse
    {
        return $this->redirectToSteam();
    }

    /**
     * {@inheritdoc}
     */
    public function redirectToSteam(): RedirectResponse
    {
        return $this->steam->redirectToSteam();
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function authenticate()
    {
        if ($this->steam->validated()) {
            $result = $this->authenticated($this->request, $this->steam->getPlayer());

            if (!empty($result)) {
                return $result;
            }
        } else {
            throw new Exception('Steam Login failed. Response: '.$this->steam->getOpenIdResponse());
        }

        return $this->steam->previousPage();
    }
}