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

    public function register(string $menu, SquadMSMenuEntry $entry) : void
    {
        /* Get the menus registry or an empty array to start off */
        $menuRegistry = $this->registry->get($menu, []);

        /* Add the entry to the registry */
        $menuRegistry[] = $entry;

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
            if (!$this->registry->has($menu)) {
                Log::warning('The menu instance has not been registered!', [
                    'menu' => $menu
                ]);
            } else {
                $instance = $this->buildNewMenuInstance();

                foreach ($this->registry->get($menu, []) as $entry) {
                    /* Get the condition from the entry, this should be bool, callable or array/string */
                    $condition = $entry->getCondition();

                    /* Add the item conditionally based on Permissions or the boolean equiv of the $condition */
                    if (is_array($condition) || is_string($condition)) {
                        $instance->addIfCan($condition, $entry->render());
                    } else {
                        $instance->addIf($condition, $entry->render());
                    }
                }

                $this->cache->put($menu, $instance);

                return $instance;
            }
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