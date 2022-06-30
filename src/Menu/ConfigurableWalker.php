<?php

namespace SquadMS\Foundation\Menu;

use Illuminate\View\ComponentAttributeBag;
use SquadMS\Foundation\Menu\Contracts\Walker;

class ConfigurableWalker extends Walker
{
    private ?string $itemParentTag = 'li';

    private array  $itemParentClass = [];

    private array  $itemParentActiveClass = ['active'];

    private array  $itemParentAttributes = [];

    private array $itemClass = [];

    private array $itemActiveClass = ['active'];

    private array $itemAttributes = [];

    public function set(
        false|null|string $itemParentTag = false,
        ?array $itemParentClass = null,
        ?array $itemParentActiveClass = null,
        ?array $itemParentAttributes = null,
        ?array $itemClass = null,
        ?array $itemActiveClass = null,
        ?array $itemAttributes = null,
    ): void {
        if ($itemParentTag !== false) {
            $this->itemParentTag = $itemParentTag;
        }

        foreach ([
            'itemParentClass',
            'itemParentActiveClass',
            'itemParentAttributes',
            'itemClass',
            'itemActiveClass',
            'itemAttributes',
        ] as $parameter) {
            if (! is_null(${$paramenter})) {
                $this->$parameter = ${$parameter};
            }
        }
    }

    public function render(): string
    {
        $html = '';

        foreach ($this->items as $item) {
            $html .= $this->buildItem($item);
        }

        return $html;
    }

    private function buildItem(MenuItem $item): string
    {
        $content = $this->tag('a', new ComponentAttributeBag([
            'href'  => $item->resolve(),
            'class' => $this->itemClass + ($item->isActive() ? $this->itemActiveClass : []),
        ] + $this->itemAttributes), $item->label());

        if ($item->hasChildren()) {
            $content .= $this->tag('ul', new ComponentAttributeBag([]), collect($item->children())->map(fn (MenuItem $child) => $this->buildItem($child))->join(''));
        }

        return $this->tag($this->itemParentTag, new ComponentAttributeBag([
            'class' => $this->itemParentClass + ($item->isActive() ? $this->itemParentActiveClass : []),
        ] + $this->itemParentAttributes), $content);
    }

    private function tag(string $tag, ComponentAttributeBag $attributes = new ComponentAttributeBag(), string $content = ''): string
    {
        return '<'.$tag.' '.$attributes.'>'.$content.'</'.$tag.'>';
    }
}
