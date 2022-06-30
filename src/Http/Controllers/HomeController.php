<?php

namespace SquadMS\Foundation\Http\Controllers;

use Illuminate\Routing\Controller;

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
