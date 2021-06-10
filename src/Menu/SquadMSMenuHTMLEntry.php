<?php

namespace SquadMS\Foundation\Menu;

use InvalidArgumentException;
use Spatie\Menu\Item;
use Spatie\Menu\Laravel\Html;
use SquadMS\Foundation\Menu\Contracts\SquadMSMenuEntry as AbstractSquadMSMenuEntry;

class SquadMSMenuHTMLEntry extends AbstractSquadMSMenuEntry
{
    private mixed $definition;

    public function __construct(mixed $definition)
    {
        if (is_callable($definition) || is_string($definition)) {
            $this->definition = $definition;
        } else {
            throw new InvalidArgumentException('The $routeParameters parameter has to be of type callable or array.');
        }
    }

    public function render(): Item
    {
        /* Resolve the Entry markup or simply use the provided markup. */
        $html = is_callable($this->definition) ? ($this->definition)() : $this->definition;

        /* Create a new HTML Item and set its active state */
        return Html::raw($html)->setActive(fn () => $this->isActive());
    }
}
