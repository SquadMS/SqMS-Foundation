<?php

namespace SquadMS\Foundation\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;

class RBACController extends Controller
{
    /**
     * Shows the profile page
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        /* Show profile page */
        return view('squadms-foundation::admin.pages.rbac');
    }
}