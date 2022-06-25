<?php

namespace SquadMS\Foundation\Menu;

use Illuminate\Support\Facades\View;
use Illuminate\View\ComponentAttributeBag;
use SquadMS\Foundation\Menu\Contracts\Walker;

class NavigationWalker extends Walker
{
    public function render(): string
    {
        $html = '';

        foreach ($this->items as $item) {
            $html .= $this->renderItem($item);
        }

        return $html;
    }

    private function renderItem(MenuItem $item) : string
    {
        if ($item->hasChildren()) {
            return $this->buildDropdown($item)->render();
        } else {
            return $this->buildItem($item)->render();
        }
    }

    private function buildDropdown(MenuItem $item): \Illuminate\Contracts\View\View
    {
        return View::make('sqms-foundation::components.navigation.dropdown', [
            'attributes' => new ComponentAttributeBag([]),
            'title'      => $item->label(),
            'links'      => collect($item->children())->map(fn (MenuItem $child) => $this->renderItem($child))->join('')
        ]);
    }

    private function buildItem(MenuItem $item): \Illuminate\Contracts\View\View
    {
        return View::make('sqms-foundation::components.navigation.item', [
            'attributes' => new ComponentAttributeBag([]),
            'title'      => $item->label(),
            'link'       => $item->resolve()
        ]);
    }
}
