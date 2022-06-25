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
        /* Show home page */
        return view('sqms-foundation::home');
    }
}
