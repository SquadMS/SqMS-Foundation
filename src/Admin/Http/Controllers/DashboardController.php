<?php

namespace SquadMS\Foundation\Admin\Http\Controllers;

use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    /**
     * Shows the profile page
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        /* Show profile page */
        return view('squadms-foundation::admin.pages.dashboard');
    }
}