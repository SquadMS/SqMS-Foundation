<?php

namespace SquadMS\Foundation\Admin\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

class CheckAdminAreaAccess
{
    public function handle($request, Closure $next)
    {
        if ($request->user && ($request->user->isSystemAdmin() || $request->user->can('admin'))) {
            return $next($request);
        } else {
            return redirect()->route(Config::get('sqms.routes.def.home.name'));
        }
    }
}