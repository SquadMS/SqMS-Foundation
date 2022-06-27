<?php

namespace SquadMS\Foundation\View\Components\Templates;

use Illuminate\View\Component;

class PageTemplate extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('squadms-foundation::templates.page');
    }
}