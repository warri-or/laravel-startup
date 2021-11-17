<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModulePermission {
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param $module_id
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $module_id) {
        if (check_module_permission($module_id)) {
            return $next($request);
        }
        return redirect()->route('permissionDenied');
    }
}
