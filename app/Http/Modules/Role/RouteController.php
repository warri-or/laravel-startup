<?php

namespace App\Http\Modules\Role;

use App\Http\Controllers\Controller;
use App\Models\Role\RoleRoute;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    private $route_service;

    public function __construct(RouteService $route_service){
        $this->route_service = $route_service;
    }
    public function updateRouteList(){
        return $this->route_service->updateRouteList();
    }
    public function getRouteByType(Request $request){
        $data['routes'] = RoleRoute::where('module_id',$request->module_id)->get();
        $data['role_action'] = $request->role_action ?? [];
        return view('admin.role.role_list_by_type',$data);
    }

    public function updateRouteName(Request $request){
        try {
            RoleRoute::where('id',$request->route_id)->update(['name'=>$request->route_name]);
            $data['route'] = RoleRoute::where('id',$request->route_id)->first();
            return jsonResponse(TRUE)->message(__('Route name updated successfully.'))->data($data);
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->default();
        }
    }
}
