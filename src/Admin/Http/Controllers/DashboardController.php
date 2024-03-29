<?php

namespace SquadMS\Foundation\Admin\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;

class DashboardController extends Controller
{
    use AuthorizesRequests;

    /**
     * Shows the profile page.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        /* Authorize the action */
        $this->authorize(Config::get('sqms.permissions.module').' admin');

        /* Show profile page */
        return view('sqms-foundation::admin.pages.dashboard');
    }
}
