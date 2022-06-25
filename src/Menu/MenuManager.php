<?php

namespace SquadMS\Foundation\Menu;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;
use RyanChandler\FilamentNavigation\Models\Navigation;
use RyanChandler\FilamentNavigation\Facades\FilamentNavigation;
use Spatie\Menu\Laravel\Html;
use Spatie\Menu\Laravel\Menu;
use Spatie\Menu\Laravel\View as MenuView;
use SquadMS\Foundation\Themes\Settings\ThemesNavigationsSettings;

class MenuManager
{
    private array $resolvers = [];

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

    public function addType(string $name, \Closure $resolver, array $actions = [])
    {
        /* Register item type resolver */
        $this->resolvers[Str::slug($name)] = $resolver;

        /* Register item type to navigations plugin */
        FilamentNavigation::addItemType($name, $actions);
    }

    private function structure(array $items): array
    {
        $menu = [];

        foreach ($items as $item) {
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
