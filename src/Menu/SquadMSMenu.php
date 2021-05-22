<?php

namespace SquadMS\Foundation\Menu;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Spatie\Menu\Laravel\Menu;
use Spatie\Menu\Laravel\Facades\Menu as FacadesMenu;
use SquadMS\Foundation\Menu\Contracts\SquadMSMenuEntry;

class SquadMSMenu {
    protected Collection $registry;
    protected Collection $cache;

    function __construct() {
        $this->registry = new Collection();
        $this->cache    = new Collection();
    }

    /**
     * Add a MenuEntry to the registry.
     *
     * @param string $menu
     * @param SquadMSMenuEntry $entry
     * @return void
     */
    public function register(string $menu, SquadMSMenuEntry $entry) : void
    {
        /** @var Collection Get the menus registry or an empty array to start off */
        $menuRegistry = $this->registry->get($menu, new Collection([]));

        /* Add the entry to the registry */
        $menuRegistry->push($entry);

        /* Put the registry back into the menu registry */
        $this->registry->put($menu, $menuRegistry);

        /* Modified, clear the cache */
        $this->cache->forget($menu);
    }

    /**
     * Retrieves the given Menu instance. If it
     * is not already built it will build a new one.
     *
     * @param string $menu
     * @return Menu
     */
    public function getMenu(string $menu) : Menu
    {
        return $this->cache->get($menu, function () use ($menu) {
            $instance = $this->buildNewMenuInstance();

            /* Check if the menu has been registered yet */
            if (!$this->registry->has($menu)) {
                /* Softly notify that the menu has not been registered */
                Log::warning('The menu instance has not been registered!', [
                    'menu' => $menu
                ]);
            } else {
                /* Get the menu entries definitions from the registry and order them */
                $entries = $this->registry->get($menu, new Collection())->sortby(fn (SquadMSMenuEntry $item, $key) => $item->getOrder());

                /* Build the Menu */
                $instance->fill($entries, function ($menu, $entry) {
                    /* Get the condition from the entry, this should be bool, callable or array/string */
                    $condition = $entry->getCondition();

                    /* Add the item conditionally based on Permissions or the boolean equiv of the $condition */
                    if (is_array($condition) || is_string($condition)) {
                        $menu->addIfCan($condition, $entry->render());
                    } else {
                        $menu->addIf($condition, $entry->render());
                    }
                });
            }

            /* Cache the built menu */
            $this->cache->put($menu, $instance);

            return $instance;
        });
    }

    /**
     * Returns a list of all registered menus
     *
     * @return array
     */
    public function getMenus() : array
    {
        return $this->menus->keys()->toArray();
    }

    /**
     * Helper to create a new Menu instance and apply
     * some configuration to it.
     *
     * @return Menu
     */
    private function buildNewMenuInstance() : Menu
    {
        /* Create a new Menu instance and apply the configured active class */
        $menu = FacadesMenu::new()->setActiveClass('active');

        /* Change active class to be on link if configured */
        if (Config::get('sqms.menu.activeClassOnLink', true)) {
            $menu->setActiveClassOnLink();
        }
        
        return $menu;
    }
}