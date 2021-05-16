<?php

namespace SquadMS\Foundation\Menu;

use Spatie\Menu\Laravel\Link;

class SquadMSMenuEntry
{
    private string $definition;
    private string $title;
    private bool $isRoute;
    private array $routeParameters;

    private mixed $active = null;
    private mixed $condition = true;

    function __construct(string $routeOrUrl, string $title, bool $isRoute = false, array $routeParameters = [])
    {
        $this->definition = $routeOrUrl;
        $this->title = $title;
        $this->isRoute = $isRoute;
        $this->routeParameters = $routeParameters;
    }

    public function toLink() : Link
    {
        $url = $this->definition;

        if ($this->isRoute) {
            $url = route($url, $this->routeParameters);
        }
        
        return (new Link($url, $this->title))->setActive($this->isActive());
    }

    public function setCondition(mixed $condition) : self
    {
        $this->condition = $condition;

        return $this;
    }

    public function getCondition() : mixed
    {
        return $this->condition; 
    }

    public function setActive(mixed $active) : self
    {
        $this->active = $active;

        return $this;
    }

    private function isActive() : bool
    {
        if (is_callable($this->active)) {
            /* Execute the condition callable and return its result */
            return ($this->active)();
        } else {
            /* Not supported or bool, make sure the return value is bool anyways by double flipping the condition */
            return !!$this->active;
        }
    }
}