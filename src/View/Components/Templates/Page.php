<?php

namespace SquadMS\Foundation\View\Components\Templates;

use Illuminate\View\Component;

class Page extends Component
{
    public string $title;

    /**
     * Create the component instance.
     *
     * @param  ?string  $title
     * @return void
     */
    public function __construct(string $title = '')
    {
        $this->title = $title;
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('sqms-foundation::templates.page');
    }
}
