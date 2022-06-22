<?php

namespace SquadMS\Foundation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Spatie\Translatable\HasTranslations;
use SquadMS\Foundation\Facades\MenuManager;

class MenuItem extends Model
{
    use HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'content'
    ];

    protected $casts = [
        'content' => 'array'
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatable = ['name'];

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
     * Accessor to get the human readable name of the MenuItemType
     * this MenuItem instance does have.
     */
    public function typeName(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($type = MenuManager::getItemType($this->type)) {
                    return $type->name();
                }
                return null;
            }
        );
    }
}
