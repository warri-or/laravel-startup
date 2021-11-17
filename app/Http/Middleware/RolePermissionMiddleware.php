<?php

namespace App\Http\Middleware;

use App\Models\Role\Role;
use App\Models\Role\RoleRoute;
use App\Models\RoleRoutePermission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolePermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next) {
        $user = Auth::user();
        if (empty(request()->route()->getName())) {
            $url = strtok($request->getRequestUri(), '?');
        } else {
            $url = request()->route()->getName();
        }
        if ($user->default_module_id == MODULE_SUPER_ADMIN){
            return $next($request);
        }else if ($this->checkRolePermission($url, $user->role)) {
            return $next($request);
        }else{
            return redirect()->route('permissionDenied')->with('dismiss', 'Permission denied');
        }
    }

    public function checkRolePermission($userAction, $userRole) {
        $action = RoleRoute::where('name', $userAction)->orWhere('url', $userAction)->first();
        $role_route_permission_map = RoleRoutePermission::where('role_id', $userRole)->get();
        $permitted_route = [];
        if (isset($role_route_permission_map)){
            foreach ($role_route_permission_map as $route){
                if(!empty($route->routes)){
                    $permitted_route = array_merge($permitted_route,explode('|', $route->routes));
                }
            }
        }
        if (isset($action->id) && in_array($action->id, $permitted_route)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}
