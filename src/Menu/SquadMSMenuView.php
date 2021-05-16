<?php

namespace SquadMS\Foundation\Menu;

use Spatie\Menu\Laravel\View;

class SquadMSMenuView extends View
{
    protected mixed $activeOverride = false;

    /**
     * @inheritDoc
     */
    public function setActive($active = true)
    {
        $this->activeOverride = $active;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function isActive(): bool
    {
        return is_callable($this->activeOverride) ? ($this->activeOverride)() : !!$this->activeOverride;
    }

    public function render(): string
    {
        return parent::render();
    }
}