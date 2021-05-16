<?php

namespace SquadMS\Foundation\Menu;

use InvalidArgumentException;
use Illuminate\Support\Facades\Config;
use Illuminate\View\ComponentAttributeBag;
use Spatie\Menu\Laravel\View;

class SquadMSMenuEntry
{
    private string $definition;
    private string $title;
    private bool $isRoute;
    private mixed $routeParameters;

    private mixed $active = false;
    private mixed $condition = true;

    function __construct(string $routeOrUrl, string $title, bool $isRoute = false, mixed $routeParameters = [])
    {
        $this->definition = $routeOrUrl;
        $this->title = $title;
        $this->isRoute = $isRoute;

        if (is_callable($routeParameters) || is_array($routeParameters)) {
            $this->routeParameters = $routeParameters;
        } else {
            throw new InvalidArgumentException('The $routeParameters parameter has to be of type callable or array.');
        }
    }

    public function render() : View
    {
        $url = $this->definition;

        if ($this->isRoute) {
            $url = route($url, is_callable($this->routeParameters) ? ($this->routeParameters)() : $this->routeParameters);
        }
        
        return SquadMSMenuView::create(Config::get('sqms.theme') . '::' . Config::get('sqms.menu.entry-view'), [
            'attributes' => new ComponentAttributeBag([]),
            'link'   => $url,
            'title'  => $this->title,
        ])->setActive(fn () => $this->isActive());
    }

    public function setCondition(mixed $condition) : self
    {
        if (is_callable($condition) || is_array($condition) || is_string($condition) || is_bool($condition)) {
            $this->condition = $condition;
        } else {
            throw new InvalidArgumentException('The $condition parameter has to be of type callable, array, string or bool.');
        }

        return $this;
    }

    public function getCondition() : mixed
    {
        return $this->condition; 
    }

    public function setActive(mixed $active) : self
    {
        if (is_callable($active) || is_bool($active)) {
            $this->active = $active;
        } else {
            throw new InvalidArgumentException('The $active parameter has to be of type callable or bool.');
        }
        
        return $this;
    }

    public function isActive() : bool
    {
        if (is_callable($this->active)) {
            /* Execute the condition callable and return its result */
            return ($this->active)($this);
        } else {
            /* Not supported or bool, make sure the return value is bool anyways by double flipping the condition */
            return !!$this->active;
        }
    }
}