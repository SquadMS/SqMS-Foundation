<?php

namespace SquadMS\Foundation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use SquadMS\Foundation\Models\SquadMSUser;

class WebsocketToken extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token',
        'session_id',
    ];

    /**
     * Get the User that owns the Websocket Token.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(SquadMSUser::class);
    }
}