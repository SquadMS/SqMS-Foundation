<?php

namespace SquadMS\Foundation\Menu\Contracts;

abstract class Walker
{
    protected readonly array $items;

    function __construct(array $items)
    {
        $this->items = $items;
    }

    abstract public function render(): string;
}
