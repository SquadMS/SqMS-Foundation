<?php

namespace SquadMS\Foundation;

use Illuminate\Container\Container;
use Illuminate\Support\Arr;

class SquadMSPermissions {
    protected array $permissions = [];

    function __construct() {
        //
    }

    public function define(string $modulePrefix, string $definition, string $displayName) : void
    {
        if (!Arr::has($this->permissions, $modulePrefix)) {
            Arr::set($this->permissions, $modulePrefix, []);
        }

        Arr::set($this->permissions[$modulePrefix], $definition, $displayName);
    }

    public function getPermissions() : array
    {
        return $this->permissions;
    }

    public static function getInstance() : self
    {
        return Container::getInstance()->make(self::class);
    }
}