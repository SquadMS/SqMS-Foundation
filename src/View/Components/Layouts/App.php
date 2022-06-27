<?php

namespace SquadMS\Foundation\View\Components\Layouts;

use Illuminate\View\Component;
use SquadMS\Foundation\Facades\SquadMSNavigation;
use SquadMS\Foundation\Menu\Contracts\Walker;
use SquadMS\Foundation\Menu\NavigationWalker;

class App extends Component
{
    public string $mainClass;

    public Walker $navWalker;

    /**
     * Create the component instance.
     *
     * @param  ?string $mainClass
     * @return void
     */
    public function __construct(string $mainClass = '')
    {
        $this->mainClass = $mainClass;
        $this->navWalker = new NavigationWalker(SquadMSNavigation::get('main'));
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