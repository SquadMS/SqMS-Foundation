<?php

namespace SquadMS\Foundation;

use Illuminate\Support\Collection;

class SquadMSPermissions {
    protected Collection $store;

    function __construct() {
        $this->store = new Collection();
    }

    public function define(string $modulePrefix, string $definition, string $displayName) : void
    {
        $this->store->put(
            $modulePrefix,
            array_merge($this->store->get($modulePrefix, [
                $definition => $displayName,
            ]))
        );
    }

    /**
     * Returns a list of all registered module prefixes
     *
     * @return array
     */
    public function getModules() : array
    {
        return $this->store->keys()->toArray();
    }

    /**
     * Returns an array of the Permission definitions.
     * The returned definitions are prefixed by module
     * and unique.
     * 
     * If a module is provided it will only return 
     * definitions for that module.
     *
     * @return array
     */
    public function getPermissions(?string $modulePrefix = null) : array
    {
        /* Get the Store of filter it */
        $filteredStore = is_null($modulePrefix) ? $this->store : $this->store->filter(fn($value, $key) => $key === $modulePrefix);

        $output = [];

        foreach ($filteredStore as $modulePrefix => $definitions) {
            foreach ($definitions as $definition => $displayName) {
                $output[$modulePrefix . ' ' . $definition] = $displayName;
            }
        }

        /* Make sure that we do not return duplicate definitions */
        return array_unique($output);
    }
}