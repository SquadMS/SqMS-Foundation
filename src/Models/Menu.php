<?php

namespace SquadMS\Foundation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the User that owns the Websocket Token.
     */
    public function menuMenuItems(): HasMany
    {
        return $this->hasMany(MenuMenuItem::class)->orderByRaw('case when parent_id IS NULL THEN id else parent_id end, `order`');
    }

    /**
     * Get the User that owns the Websocket Token.
     */
    public function menuItems(): BelongsToMany
    {
        return $this->belongsToMany(MenuItem::class);
    }
}
