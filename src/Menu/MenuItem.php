<?php

namespace SquadMS\Foundation\Menu;

class MenuItem
{
    private string $label;
    private ?\Closure $resolver = null;
    private ?\Closure $active   = null;

    private array $children = [];

    public static function make(string $label, ?\Closure $resolver = null): self
    {
        return new self($label, $resolver);
    }

    protected function __construct(string $label, ?\Closure $resolver = null)
    {
        $this->setLabel($label);
        $this->setResolver($resolver);
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function setResolver(?\Closure $resolver = null): void
    {
        $this->resolver = $resolver;
    }

    public function resolve(): ?string
    {
        if (! is_null($this->resolver)) {
            return ($this->resolver)();
        }
        
        return null;
    }

    public function setActive(\Closure $active = null): void
    {
        $this->active = $active;
    }

    public function isActive(): bool
    {
        if (! is_null($this->active)) {
            return ($this->active)();
        }

        return false;
    }

    public function addChild(MenuItem ...$children): void
    {
        foreach ($children as $child) {
            $this->children[] = $child;
        } 
    }

    public function children(): array
    {
        return $this->children;
    }

    public function hasChildren(): bool
    {
        return !!count($this->children());
    }
}
