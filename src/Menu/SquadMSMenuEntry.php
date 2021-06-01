<?php

namespace SquadMS\Foundation\Menu;

use InvalidArgumentException;
use Illuminate\Support\Facades\Config;
use Illuminate\View\ComponentAttributeBag;
use Spatie\Menu\Item;
use SquadMS\Foundation\Menu\Contracts\SquadMSMenuEntry as AbstractSquadMSMenuEntry;

class SquadMSMenuEntry extends AbstractSquadMSMenuEntry
{
    private string $definition;
    private mixed $title;
    private bool $isRoute;
    private mixed $routeParameters;

    private ?string $view = null;

    function __construct(string $routeOrUrl, callable|string $title, bool $isRoute = false, mixed $routeParameters = [])
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

    public function setView(?string $view = null) : self
    {
        $this->view = $view;
        return $this;
    }

    public function render() : Item
    {
        $url = $this->definition;

        if ($this->isRoute) {
            $url =  fn () => route($url, is_callable($this->routeParameters) ? ($this->routeParameters)() : $this->routeParameters);
        }
        
        return SquadMSMenuView::create($this->view ?? Config::get('sqms.theme') . '::' . Config::get('sqms.menu.entry-view'), [
            'attributes' => new ComponentAttributeBag([]),
            'link'   => $url,
            'title'  => is_callable($this->title) ? ($this->title)() : $this->title,
        ])->setActive(fn () => $this->isActive());
    }
}