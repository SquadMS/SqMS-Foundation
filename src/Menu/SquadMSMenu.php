<?php

namespace SquadMS\Foundation\Menu;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Spatie\Menu\Laravel\Menu;
use Spatie\Menu\Laravel\Facades\Menu as FacadesMenu;
use SquadMS\Foundation\Facades\SquadMSModuleRegistry;
use SquadMS\Foundation\Menu\Contracts\SquadMSMenuEntry;

class SquadMSMenu {
    protected Collection $definitions;
    protected Collection $prepend;
    protected Collection $append;

    protected Collection $cache;

    function __construct() {
        $this->definitions = new Collection();
        $this->prepend = new Collection();
        $this->append = new Collection();

        $this->cache    = new Collection();
    }

    /**
     * Add a MenuEntry to the definitions.
     *
     * @param string $menu
     * @param SquadMSMenuEntry $entry
     * @return void
     */
    public function register(string $menu, SquadMSMenuEntry $entry) : void
    {
        /** @var Collection Get the menus definitions or an empty array to start off */
        $menuDefinitions = $this->definitions->get($menu, new Collection([]));

        /* Add the entry to the definitions */
        $menuDefinitions->push($entry);

        /* Put the definitions back into the menu definitions */
        $this->definitions->put($menu, $menuDefinitions);

        /* Modified, clear the cache */
        $this->cache->forget($menu);
    }

    /**
     * Prepend the menu with the given markup.
     *
     * @param string $menu
     * @param string $value
     * @return void
     */
    public function prepend(string $menu, mixed $value = '') : void
    {
        $this->prepend->put($menu, $value);
    }

    /**
     * Append the menu with the given markup.
     *
     * @param string $menu
     * @param string $value
     * @return void
     */
    public function append(string $menu, mixed $value = '') : void
    {
        $this->append->put($menu, $value);
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

            /* Register possible menu entries from SquadMS modules */
            SquadMSModuleRegistry::registerMenuEntries($menu);

            /* Check if the menu has been registered yet */
            if (!$this->definitions->has($menu)) {
                /* Softly notify that the menu has not been registered */
                Log::warning('The menu instance has not been registered!', [
                    'menu' => $menu
                ]);
            } else {
                /* Get the menu entries definitions from the definitions and order them */
                $entries = $this->definitions->get($menu, new Collection())->sortby(fn (SquadMSMenuEntry $item, $key) => $item->getOrder());

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

            /* Append and prepend the menu as configured */
            $instance->prepend(($prepend = $this->prepend->get($menu, '')) && is_callable($prepend) ? $prepend() : $prepend);
            $instance->append(($append = $this->append->get($menu, '')) && is_callable($append) ? $append() : $append);

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