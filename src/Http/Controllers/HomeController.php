<?php

namespace SquadMS\Foundation\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;

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
        return view(Config::get('sqms.theme').'::pages.home');
    }
}
