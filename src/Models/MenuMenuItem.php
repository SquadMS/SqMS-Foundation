<?php

namespace SquadMS\Foundation\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class MenuMenuItem extends Model implements Sortable
{
    use SortableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'menu_item_id',
        'order'
    ];

    protected static $unguarded = true;


    /**
     * Override configuration for spatie sortable
     *
     * @var array
     */
    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    /**
     * Get Menu the related MenuItem instance belongs to.
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Get the MenuItem that this instance is linking to the menu
     */
    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }

    /**
     * Get the MenuItem that this instance is linking to the menu
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get the MenuItem that this instance is linking to the menu
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Override for Sparie sortable query. Restrict
     * order to imminent siblings only.
     */
    public function buildSortQuery(): Builder
    {
        return static::query()
            ->where('menu_id', $this->menu_id)
            ->where('parent_id',  $this->parent_id);
    }
}
