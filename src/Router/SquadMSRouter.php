<?php

namespace SquadMS\Foundation\Router;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use SquadMS\Foundation\Router\Exceptions\DuplicateRouteDefinitionException;

class SquadMSRouter
{
    private Collection $registry;

    public function __construct()
    {
        $this->registry = new Collection();
    }

    public function define(string $identifier, callable $definition): void
    {
        if ($this->registry->has($identifier)) {
            throw new DuplicateRouteDefinitionException('A route definition with identifier "'.$identifier.'" has aleady been registered!');
        }

        $this->registry->put($identifier, $definition);
    }

    public function register(): void
    {
        foreach ($this->registry as $definition) {
            $definition();
        }
    }

    public static function webRoutes(array $definitions): void
    {
        /* Define routes from config */
        foreach ($definitions as $definition) {
            /* Create the definitor as an anonymous function */
            $define = function () use ($definition) {
                $type = Arr::get($definition, 'type', 'get');

                Route::$type(Arr::get($definition, 'path', '/'), [Arr::get($definition, 'controller'), Arr::get($definition, 'executor', 'show')])->middleware(Arr::get($definition, 'middlewares'))->name(Arr::get($definition, 'name'));
            };

            if (Arr::get($definition, 'localized', false)) {
                Route::localized(function () use ($define) {
                    $define();
                });
            } else {
                $define();
            }
        }
    }
}
