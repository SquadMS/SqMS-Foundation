<?php

namespace SquadMS\Foundation\View\Components\Layouts;

use Illuminate\View\Component;

class App extends Component
{
    public string $mainClass;

    /**
     * Create the component instance.
     *
     * @param  ?string $mainClass
     * @return void
     */
    public function __construct(string $mainClass = '')
    {
        $this->mainClass = $mainClass;
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('sqms-foundation::layouts.app');
    }
}