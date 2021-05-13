<?php

namespace SquadMS\Foundation;

use Illuminate\Support\Arr;

class SquadMSRouter {
    private array $registry = [];

    public function define(string $identifier, callable $definition) : void
    {
        Arr::set($this->registry, $identifier, $definition);
    }

    public function register() : void
    {
        foreach ($this->registry as $definition) {
            $definition();
        }
    }
}