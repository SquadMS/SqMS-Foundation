<?php

namespace SquadMS\Foundation\Menu;

use Spatie\Menu\Laravel\Link;

class SquadMSMenuEntry
{
    private string $definition;
    private string $title;
    private bool $isRoute;
    private callable|array $routeParameters;

    private callable|bool $active = null;
    private callable|array|string|bool $condition = true;

    function __construct(string $routeOrUrl, string $title, bool $isRoute = false, callable|array $routeParameters = [])
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
            $url = route($url, is_callable($this->routeParameters) ? ($this->routeParameters)() : $this->routeParameters);
        }
        
        return (new Link($url, $this->title))->setActive($this->isActive());
    }

    public function setCondition(callable|array|string|bool $condition) : self
    {
        $this->condition = $condition;

        return $this;
    }

    public function getCondition() : mixed
    {
        return $this->condition; 
    }

    public function setActive(callable|bool $active) : self
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