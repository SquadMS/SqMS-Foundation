<?php

namespace SquadMS\Foundation\Router;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use SquadMS\Foundation\Router\Exceptions\DuplicateRouteDefinitionException;

class SquadMSRouter {
    private Collection $registry;

    function __construct()
    {
        $this->registry = new Collection();   
    }

    public function define(string $identifier, callable $definition) : void
    {
        if ($this->registry->has($identifier)) {
            throw new DuplicateRouteDefinitionException('A route definition with identifier "' . $identifier . '" has aleady been registered!');
        }
        
        $this->registry->put($identifier, $definition);
    }

    public function register() : void
    {
        foreach ($this->registry as $definition) {
            $definition();
        }
    }
}