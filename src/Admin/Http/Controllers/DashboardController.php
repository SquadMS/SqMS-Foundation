<?php

namespace SquadMS\Foundation\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;

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
        return view(Config::get('sqms.theme') . '::admin.pages.dashboard');
    }
}