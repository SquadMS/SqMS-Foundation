<?php

namespace SquadMS\Foundation\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use SquadMS\Foundation\Models\Menu;
use SquadMS\Foundation\Models\MenuMenuItem;

class HomeController extends Controller
{
    /**
     * Shows the profile page.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //return MenuMenuItem::scoped([ 'menu_id' => Menu::firstOrFail()->id ])->fixTree(); // OK
        //return MenuMenuItem::scoped([ 'menu_id' => Menu::firstOrFail()->id ])->whereNull('parent_id')->with('descendants')->get();
        return Menu::firstOrFail()->menuMenuItems()->whereNull('parent_id')->with('descendants')->get();

        /* Show home page */
        //return view('sqms-foundation::home');
    }
}
