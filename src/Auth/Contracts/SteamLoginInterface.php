<?php

namespace SquadMS\Foundation\Auth\Contracts;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

interface SteamLoginInterface
{
    /**
     * Return the steamid if validated.
     *
     * @return string|null
     */
    public function validate(Request $request): ?string;

    /**
     * Redirect the user to steam's login page.
     *
     * @return RedirectResponse
     */
    public function redirectToSteam(Request $request, ?string $redirectTo): RedirectResponse;

    /**
     * Return the steam login url.
     *
     * @return string
     */
    public function buildLoginUrl(Request $request): string;

    /**
     * Is the current request valid for.
     *
     * @param  \Illuminate\Http\Request|null  $request
     * @return bool
     */
    public function validRequest(Request $request): bool;
}
