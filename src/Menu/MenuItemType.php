<?php

namespace SquadMS\Foundation\Menu;

class MenuItemType
{
    private string $name;
    private array $actions;
    
    function __construct(string $name, array $actions)
    {
        $this->name = $name;
        $this->actions = $actions;
    }

    /**
     * Get the name of this MenuItemType instance.
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Get the actions of this SquadMSMenuItemType instance.
     * These actions will be displayed to the admin for 
     * configuring the MenuItemType. 
     */
    public function actions(): array
    {
        return $this->actions;
    }
}
