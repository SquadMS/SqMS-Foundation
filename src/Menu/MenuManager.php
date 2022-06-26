<?php

namespace SquadMS\Foundation\Menu;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use RyanChandler\FilamentNavigation\Models\Navigation;
use RyanChandler\FilamentNavigation\Facades\FilamentNavigation;
use SquadMS\Foundation\Themes\Settings\ThemesNavigationsSettings;

class MenuManager
{
    private array $resolvers = [];

    private array $conditions = [];

    public function addType(string $name, \Closure $resolver, array $actions = [], ?\Closure $condition = null)
    {
        /* Register item type resolver */
        $this->resolvers[Str::slug($name)] = $resolver;

        /* Register item type condition */
        if (! is_null($condition)) {
            $this->conditions[Str::slug($name)] = $condition;
        }

        /* Register item type to navigations plugin */
        FilamentNavigation::addItemType($name, $actions);
    }

    public function get(string $slot, ?\Closure $submenu = null): array
    {
        /** @var ThemesNavigationsSettings */
        $setting = resolve(ThemesNavigationsSettings::class);

        foreach ($setting->slotHandles as $pair) {
            if (Arr::get($pair, 'slot') === $slot && $navigation = Navigation::find(Arr::get($pair, 'navigation'))) {
                return $this->structure($navigation->items, $submenu);
            }
        }

        return [];
    }

    private function structure(array $items): array
    {
        $menu = [];

        foreach ($items as $item) {
            /* Check if this item has a display condition and omit it if the condition is not met */
            if (Arr::has($this->conditions, $item['type']) && !$this->conditions[$item['type']]()) {
                continue;
            }

            $menuItem = MenuItem::make($item['label'], $item['type'] ? Arr::get($this->resolvers, $item['type']) : null);

            if (count($item['children'])) {
                call_user_func_array(
                    [$menuItem, 'addChild'],
                    $this->structure($item['children'])
                );
            }

            $menu[] = $menuItem;
        }

        return $menu;
    }
}
