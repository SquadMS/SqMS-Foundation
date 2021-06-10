<?php

namespace SquadMS\Foundation\Menu\Contracts;

use InvalidArgumentException;
use Spatie\Menu\Item;

abstract class SquadMSMenuEntry
{
    private mixed $active = false;
    private mixed $condition = true;

    private int $order = 0;

    abstract public function render(): Item;

    public function setCondition(mixed $condition): self
    {
        if (is_callable($condition) || is_array($condition) || is_string($condition) || is_bool($condition)) {
            $this->condition = $condition;
        } else {
            throw new InvalidArgumentException('The $condition parameter has to be of type callable, array, string or bool.');
        }

        return $this;
    }

    public function getCondition(): mixed
    {
        return $this->condition;
    }

    public function setActive(mixed $active): self
    {
        if (is_callable($active) || is_bool($active)) {
            $this->active = $active;
        } else {
            throw new InvalidArgumentException('The $active parameter has to be of type callable or bool.');
        }

        return $this;
    }

    public function isActive(): bool
    {
        if (is_callable($this->active)) {
            /* Execute the condition callable and return its result */
            return ($this->active)($this);
        } else {
            /* Not supported or bool, make sure the return value is bool anyways by double flipping the condition */
            return (bool) $this->active;
        }
    }

    public function setOrder(int $order = 0): self
    {
        $this->order = $order;

        return $this;
    }

    public function getOrder(): int
    {
        return $this->order;
    }
}
