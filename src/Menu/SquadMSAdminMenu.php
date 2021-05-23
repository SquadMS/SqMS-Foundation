<?php

namespace SquadMS\Foundation\Menu;

use Illuminate\Support\Collection;

class SquadMSAdminMenu {
    private Collection $store;

    function __construct()
    {
        $this->store = new Collection();    
    }

    /**
     * Registers an menu to be rendered in the admin menu at order.
     *
     * @param string $menu
     * @param integer $order
     * @return void
     */
    public function register(string $menu, int $order = 0) : void
    {
        $this->store->put($menu, $order);
    }

    /**
     * Retrieves the menus in proper order.
     *
     * @return Collection
     */
    public function retrieve() : Collection
    {
        return $this->store->sortBy(fn ($entry) => $entry)->keys();
    }
}