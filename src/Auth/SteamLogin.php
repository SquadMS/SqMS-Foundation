<?php

namespace SquadMS\Foundation\Auth;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use SquadMS\Foundation\Auth\Contracts\SteamLoginInterface;

class SteamLogin implements SteamLoginInterface
{
    /**
     * Steam OpenID URL.
     *
     * @var string
     */
    const OPENID_STEAM = 'https://steamcommunity.com/openid/login';

    /**
     * OpenID Specs.
     *
     * @var string
     */
    const OPENID_SPECS = 'http://specs.openid.net/auth/2.0';

    /**
     * Default OpenID form params.
     *
     * @var array
     */
    protected static $openIdParams = [
        'openid.ns'         => self::OPENID_SPECS,
        'openid.mode'       => 'checkid_setup',
        'openid.identity'   => self::OPENID_SPECS.'/identifier_select',
        'openid.claimed_id' => self::OPENID_SPECS.'/identifier_select',
    ];

    /**
     * Laravel Application
     */
    protected \Illuminate\Contracts\Foundation\Application $app;

    /**
     * Guzzle instance.
     *
     * @var \GuzzleHttp\Client
     */
    protected $guzzle;

    /**
     * OpenID realm.
     *
     * @var string
     */
    protected $realm;

    /**
     * ?redirect parameter used for automatic handling to the previous page a user was on.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Login URL to Steam.
     *
     * @var string
     */
    protected $loginUrl;

    /**
     * SteamLogin constructor.
     * 
     * @throws \Exception Throws an exception if the current PHP installation can not calculate SteamID's
     */
    public function __construct()
    {
        if (PHP_INT_SIZE !== 8) {
            throw new \Exception('x86_64 PHP is required to convert SteamID\'s!');
        }

        $this->setGuzzle(new GuzzleClient());
    }

    /**
     * Build the login url with optional openid.return_to and ?redirect.
     *
     * @param \Illuminate\Http\Request $request
     * @param string|null $return
     * @param string|null $redirectTo
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function buildLoginUrl(Request $request, ?string $return = null, ?string $redirectTo = null): string
    {
        $secure = $request->secure();

        if ($secure && !$request->isSecure()) {
            URL::forceScheme('https');
        }

        $authRoute = route(Config::get('sqms.auth.routes.auth'));

        URL::forceScheme($secure ? 'https' : 'http');

        if (empty($return) && !empty($authRoute)) {
            $return = $authRoute;
        }

        if (empty($return) && empty($authRoute)) {
            $authRoute = $return = route(config('steam-login.routes.auth'));
        }

        $this->setRedirectTo($redirectTo);

        $params = self::$openIdParams;
        $this->realm = $this->getRealm($request);

        if (parse_url($this->realm, PHP_URL_HOST) !== parse_url($return, PHP_URL_HOST)) {
            throw new \InvalidArgumentException(sprintf('realm: `%s` and return_to: `%s` do not have matching hosts', $this->realm, $return));
        }

        $params['openid.realm'] = $this->realm;
        $params['openid.return_to'] = $return . (!empty($this->redirectTo) ? '?' . http_build_query(['redirect' => $this->redirectTo]) : '');

        return self::OPENID_STEAM . '?' . http_build_query($params);
    }

    /**
     * @param string|null $return
     *
     * @return string
     *
     * @deprecated
     */
    public function createLoginUrl(Request $request, ?string $return = null): string
    {
        return $this->buildLoginUrl($request, $return);
    }

    /**
     * @param string $redirectTo
     *
     * @throws InvalidArgumentException
     *
     * @return \SquadMS\Foundation\Auth\SteamLogin
     */
    public function setRedirectTo(string $redirectTo = null): self
    {
        if (empty($redirectTo)) {
            $redirectTo = URL::previous();
        }

        if (in_array($redirectTo, [route(Config::get('sqms.auth.routes.login')), route(Config::get('sqms.auth.routes.auth'))])) {
            $redirectTo = route(Config::get('sqms.routes.def.home.name'));
        } elseif (!filter_var($redirectTo, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('$redirectTo: `'.$redirectTo.'` is not a valid URL');
        }

        $this->redirectTo = $redirectTo;

        return $this;
    }

    /**
     * Return the ?redirect URL.
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return string
     */
    public function getRedirectTo(Request $request): string
    {
        if ($request->has('redirect')) {
            $this->setRedirectTo($request->query('redirect'));
        } elseif (empty($this->redirectTo)) {
            $this->setRedirectTo();
        }

        return $this->redirectTo;
    }

    /**
     * Set the Guzzle instance to use.
     *
     * @param \GuzzleHttp\Client $guzzle
     *
     * @return void
     */
    public function setGuzzle(GuzzleClient $guzzle): void
    {
        $this->guzzle = $guzzle;
    }

    /**
     * Set the openid.realm either by passing the URL or the domain only.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $realm
     *
     * @return \SquadMS\Foundation\Auth\SteamLogin
     */
    public function setRealm(Request $request, ?string $realm = null): self
    {
        $host = str_replace(['https://', 'http://'], '', $realm);

        if (empty($host) || filter_var($host, FILTER_VALIDATE_DOMAIN) === false) {
            $host = $request->getHttpHost();
        }

        $realm = ($request->secure() ? 'https' : 'http').'://'.$host;

        if (!filter_var($realm, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('$realm: `'.$realm.'` is not a valid URL.');
        }

        $this->realm = $realm;

        return $this;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * 
     * @return string
     */
    public function getRealm(Request $request): string
    {
        if (empty($this->realm)) {
            $this->setRealm($request);
        }

        return $this->realm;
    }

    /**
     * Check if login is valid.
     *
     * @param \Illuminate\Http\Request $request
     * @return SteamUser|null
     * 
     * @throws Exception
     */
    public function validated(Request $request): ?SteamUser
    {
        if (!$this->validRequest($request)) {
            if ($request->has('openid_error')) {
                throw new \Exception('OpenID Error: '.$request->input('openid_error'));
            }

            return false;
        }

        $steamid = $this->validate($request);

        return !empty($steamid) ? new SteamUser($steamid) : null;
    }

    /**
     * Return the steamid if validated.
     * 
     * @param \Illuminate\Http\Request $request
     *
     * @return string|null
     */
    public function validate(Request $request): ?string
    {
        if (!$request->has('openid_signed') || $request->query('openid_claimed_id') !== $request->query('openid_identity')) {
            return null;
        }

        $params = [
            'openid.sig'    => $request->query('openid_sig'),
            'openid.ns'     => self::OPENID_SPECS,
            'openid.mode'   => 'check_authentication',
            'openid.signed' => $request->query('openid_signed'),
        ];

        foreach (explode(',', $params['openid.signed']) as $param) {
            if ($param === 'signed') {
                continue;
            }

            $params['openid.'.$param] = $request->query('openid_'.$param);
        }

        $response = $this->guzzle->post($request->query('openid_op_endpoint'), [
            'timeout'     => config('steam-login.timeout'),
            'form_params' => $params,
        ]);

        $result = $response->getBody()->getContents();

        if (preg_match('#is_valid\s*:\s*true#i', $result) === 1 && preg_match('#^https?://steamcommunity.com/openid/id/([0-9]{17,25})#', $request->query('openid_claimed_id'), $matches) === 1) {
            if (is_numeric($matches[1])) {
                return $matches[1];
            }
        }

        return null;
    }

    /**
     * Redirect the user to steam's login page.
     *
     * @return RedirectResponse
     */
    public function redirectToSteam(Request $request): RedirectResponse
    {
        return redirect($this->getLoginUrl($request));
    }

    /**
     * Return the user to the page they were on before logging in
     * or home if no valid ?redirect given.
     *
     * @return RedirectResponse
     */
    public function previousPage(Request $request): RedirectResponse
    {
        return redirect($this->getRedirectTo($request));
    }

    /**
     * Return the steam login url.
     *
     * @return string
     */
    public function getLoginUrl(Request $request): string
    {
        if (empty($this->loginUrl)) {
            $this->loginUrl = $this->buildLoginUrl($request);
        }

        return $this->loginUrl;
    }

    /**
     * Check if query parameters are valid post steam login.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function validRequest(Request $request): bool
    {
        $params = [
            'openid_assoc_handle',
            'openid_claimed_id',
            'openid_sig',
            'openid_signed',
        ];

        return $request->filled($params);
    }

    /**
     * Returns Steam Login button with link.
     *
     * @param string $type
     *
     * @return string
     */
    public function loginButton(Request $request, string $type = 'small'): string
    {
        return sprintf('<a href="%s" class="laravel-steam-login-button"><img src="%s" alt="Sign In Through Steam" /></a>', $this->getLoginUrl($request), self::button($type));
    }

    /**
     * Return the URL of Steam Login buttons.
     *
     * @param string $type
     *
     * @return string
     */
    public static function button(string $type = 'small'): string
    {
        return 'https://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_0'.($type === 'small' ? 1 : 2).'.png';
    }
}