<?php

namespace SquadMS\Foundation\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Jenssegers\Agent\Agent;
use Spatie\Permission\Traits\HasRoles;
use SquadMS\Foundation\Models\WebsocketToken;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;

class SquadMSUser extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasRoles;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /* Disable Laravel's mass assignment protection */
    protected $guarded = [
        //
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'api_token',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'last_fetched' => 'datetime',
    ];

    /**
     * Get the default foreign key name for the model.
     *
     * @return string
     */
    public function getForeignKey()
    {
        return 'user_'.$this->getKeyName();
    }

    /**
     * Scope a query to only include users that have the given websocket_token.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasWebsocketToken($query, $token)
    {
        return $query->whereHas('websocketTokens', function ($query) use ($token) {
            return $query->where('token', $token);
        });
    }

    /**
     * Get the WebsocketTokens for the User.
     */
    public function websocketTokens(): HasMany
    {
        return $this->hasMany(WebsocketToken::class);
    }

    public function isSystemAdmin(): bool
    {
        return in_array($this->steam_id_64, Config::get('sqms.admins'));
    }

    public function getProfileUrlAttribute(): string
    {
        return route(Config::get('sqms.routes.def.profile.name'), [
            'steam_id_64' => $this->steam_id_64,
        ]);
    }

    public function getRunningSessions(): Collection
    {
        return collect(
            DB::connection(Config::get('session.connection'))->table(Config::get('session.table', 'sessions'))
                    ->where('user_id', $this->getAuthIdentifier())
                    ->orderBy('last_activity', 'desc')
                    ->get()
        )->map(function ($session) {
            $agent = $this->createAgent($session);

            return (object) [
                'agent'             => $agent,
                'ip_address'        => $session->ip_address,
                'is_current_device' => $session->id === Request::session()->getId(),
                'last_active'       => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }

    /**
     * Delete the other browser session records from storage.
     */
    public function deleteOtherSessionRecords(): void
    {
        if (Config::get('session.driver') !== 'database') {
            return;
        }

        DB::connection(Config::get('session.connection'))
            ->table(Config::get('session.table', 'sessions'))
            ->where('user_id', $this->getAuthIdentifier())
            ->where('id', '!=', Request::session()->getId())
            ->delete();
    }

    /**
     * Delete the current browser session record from storage.
     */
    public function deleteSessionRecord(?string $sessionId = null): void
    {
        if (Config::get('session.driver') !== 'database') {
            return;
        }

        $query = DB::connection(Config::get('session.connection'))
            ->table(Config::get('session.table', 'sessions'))
            ->where('user_id', $this->getAuthIdentifier());

        if (is_null($sessionId)) {
            $query = $query->where('id', '=', Request::session()->getId());
        } else {
            $query = $query->where('id', '=', $sessionId);
        }

        $query->delete();
    }

    public function getCurrentWebSocketToken(): ?WebsocketToken
    {
        return $this->websocketTokens()->where('session_id', Request::session()->getId())->first();
    }

    /**
     * Helper to retrieve the current user or null.
     *
     * @return null|self
     */
    public static function current(): ?self
    {
        return Auth::user();
    }

    /**
     * Create a new agent instance from the given session.
     */
    protected function createAgent(mixed $session): Agent
    {
        return tap(new Agent(), function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }

    public function canAccessFilament(): bool
    {
        return $this->can('sqms admin') || $this->isSystemAdmin();
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar;
    }
}
