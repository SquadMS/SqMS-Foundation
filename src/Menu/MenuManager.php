<?php

namespace SquadMS\Foundation\Menu;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class MenuManager
{
    /**
     * Internal registry of all SquadMSMenuItemType registered
     * by each SquadMS module.
     * 
     * @var MenuItemType[]
     */
    protected array $itemTypes;

    /**
     * Internal registry of all available menu slots registered
     * by each SquadMS Module.
     * 
     * @var string[]
     */
    protected array $slots;

    /**
     * Add a SquadMSMenuItemType to the registry.
     *
     * @param MenuItemType|string $name
     * @param array                      $actions
     *
     * @return void
     */
    public function addItemType(MenuItemType|string $name, ?array $actions = null): void
    {
        $this->itemTypes[Str::slug($name)] = new MenuItemType($name, $actions ?? []);
    }

    /**
     * Add a SquadMSMenuItemType to the registry.
     *
     * @param MenuItemType|string $name
     * @param array                      $actions
     *
     * @return void
     */
    public function addMenuSlot(string $name): void
    {
        $this->slots[] = $name;
    }

    public function getItemType(string $slug): ?MenuItemType
    {
        return Arr::get($this->itemTypes, $slug, null);
    }

    /**
     * Get the name of an MenuItemType by it's slug from the registry.
     */
    public function getItemTypeName(string $slug): ?string
    {
        return isset($this->itemTypes[$slug]) ? $this->itemTypes[$slug]->name() : null;
    }

    /**
     * Generates the options for the filament type select action.
     */
    public function generateSelectOptions(): array
    {
        return collect($this->itemTypes)
            ->map(fn (MenuItemType $type) => $type->name())
            ->toArray();
    }
}
