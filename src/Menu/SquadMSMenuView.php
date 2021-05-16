<?php

namespace SquadMS\Foundation\Menu;

use Spatie\Menu\Laravel\View;

class SquadMSMenuView extends View
{
    protected mixed $active = false;

    /**
     * @inheritDoc
     */
    public function setActive($active = true)
    {
        $this->active = $active;
    }

    /**
     * @inheritDoc
     */
    public function isActive(): bool
    {
        return is_callable($this->active) ? ($this->active)() : !!$this->active;
    }

    public function render(): string
    {
        return parent::render();
    }
}