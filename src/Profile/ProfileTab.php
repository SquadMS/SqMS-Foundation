<?php

namespace SquadMS\Foundation\Profile;

use Illuminate\Support\Str;

class ProfileTab
{
    public readonly string $component;

    public readonly string $name;

    private readonly \Closure|string $label;

    function __construct(string $component, string $name, \Closure|string|null $label = null)
    {
        $this->component = $component;
        $this->name = $name;
        $this->label = $label ?? Str::headline($this->name);
    }

    public function label(): string
    {
        if (is_callable($this->label)) {
            return ($this->label)();
        }

        return $this->label;
    }
}
