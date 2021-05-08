<?php

namespace SquadMS\Foundation\Admin\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class CheckAdminAreaAccess
{
    public function handle(Request $request, \Closure $next, ?string $permissionDefinitions = null)
    {
        if ($request->user() && ($request->user()->isSystemAdmin() || $request->user()->can('admin'))) {
            if (!is_null($permissionDefinitions) && $this->checkPermissionDefinitions($request, $permissionDefinitions)) {
                return $next($request);
            }
        }
        
        return redirect(route(Config::get('sqms.routes.def.home.name')))->withErrors('You have no permisson to do this!');
    }

    private function checkPermissionDefinitions(Request $request, string $permissionDefintions) : bool
    {
        foreach (explode(',', $permissionDefintions) as $definition) {
            if (!$request->user()->can($definition)) {
                return false;
            }
        }

        return true;
    }
}