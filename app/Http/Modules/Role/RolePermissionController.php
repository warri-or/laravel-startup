<?php

namespace App\Http\Modules\Role;

use App\Http\Controllers\Controller;
use App\Models\Role\Role;
use App\Models\Role\RoleRoute;
use App\Models\RoleRoutePermission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolePermissionController extends Controller
{
    private $role_service;

    public function __construct(RoleService $role_service){
        $this->role_service = $role_service;
    }
    public function index(Request $request){
        $role_list = Role::select('roles.*',DB::raw('GROUP_CONCAT(role_route_permissions.module_id) as module_id'))
                         ->leftJoin('role_route_permissions','roles.id','role_route_permissions.role_id')
                         ->groupBy('roles.id')
                         ->orderBy('id','desc')->get();
        if ($request->ajax()){
            return datatables($role_list)
                ->editColumn('module_id',function ($item){
                    $html = '';
                    if (!empty($item->module_id)){
                        $module_id = explode(',', $item->module_id);
                        foreach ($module_id as $value){
                            $html .= '<span class="badge badge-primary">'.MODULES[(int)$value].'</span><br>';
                        }
                    }
                    return $html;
                })->editColumn('action',function ($item){
                    $html = '<a href="javascript:void(0)" class="text-info p-1 edit_item" data-id="'.$item->id.'"><i class="fa fa-edit"></i></a>';
                    return $html;
                })
                ->rawColumns(['action', 'module_id'])
                ->make(TRUE);
        }
        return view('modules.role.roles');
    }

    public function saveRole(Request $request){
        $data['title'] = $request->title;
        $data['module_id'] = $request->module_id;
        if (!empty($request->id)){
            return $this->role_service->update($request->id,$data);
        }else{
            return $this->role_service->create($data);
        }
    }

    public function editRole(Request $request){
        return view('modules.role.create',$this->role_service->getRoleData($request->id));
    }

    public function delete(Request $request){
        return $this->role_service->delete($request->id);
    }

    public function getModulesById(Request $request){
        try {
            $module_id = $request->module_id;
            $modules = [];
            $index = 0;
            foreach (MODULES as $key=>$value){
                if (in_array($key, $module_id)){
                    $modules[$index]['key'] = $key;
                    $modules[$index]['value'] = $value;
                }
            }
            return $modules;
        }catch (\Exception $exception){

        }
    }

    public function getModuleByRole(Request $request){
        $role_id = $request->role_id;
        $module_id = RoleRoutePermission::where('role_id',$role_id)->pluck('module_id')->toArray();
        $modules = [];
        $index = 0;
        foreach (MODULES as $key=>$value){
            if (in_array($key, $module_id)){
                $modules[$index]['key'] = $key;
                $modules[$index]['value'] = $value;
                $index ++ ;
            }
        }
        $data['module_list'] = $modules;
        $data['role_id'] = $role_id;
        return view('modules.role.module_list_by_role',$data);
    }

    public function getRouteListByModuleId(Request $request){
        $data['routeList'] = RoleRoute::where('module_id',$request->module_id)->get();
        $all_routeList = RoleRoute::where('module_id',$request->module_id)->pluck('id')->toArray();
        $role_module_map = RoleRoutePermission::where(['role_id'=>$request->role_id,'module_id'=>$request->module_id])->first();
        $selected_routes = [];
        if (isset($role_module_map) && !empty($role_module_map->routes)){
           $selected_routes = explode('|', $role_module_map->routes);
        }
        $exclude_routes = array_diff($all_routeList, $selected_routes);
        $data['all_checked'] = FALSE;
        if (empty($exclude_routes)){
            $data['all_checked'] = TRUE;
        }
        $data['selected_routes'] = $selected_routes;
        return view('modules.role.route_list_table',$data);
    }

    public function updateRoleRoute(Request $request){
        try {
            $role_routes_map = RoleRoutePermission::where(['role_id'=>$request->role_id,'module_id'=>$request->module_id])->first();
            $role_routes_array = !empty($role_routes_map->routes) ? explode('|', $role_routes_map->routes) : [];
            if ($request->checked == 'true'){
                if ($request->type == 'multiple'){
                    $update_data['routes'] = !empty($request->route_id) ? implode('|', $request->route_id) : '';
                }else{
                    array_push($role_routes_array,$request->route_id);
                    $update_data['routes'] = !empty($role_routes_array) ? implode('|', $role_routes_array) : '';
                }
            }else{
                if ($request->type == 'multiple'){
                    $update_data['routes'] = '';
                }else{
                    if (($key = array_search($request->route_id, $role_routes_array)) !== false) {
                        unset($role_routes_array[$key]);
                    }
                    $update_data['routes'] = !empty($role_routes_array) ? implode('|', $role_routes_array) : '';
                }
            }
            RoleRoutePermission::where(['role_id'=>$request->role_id,'module_id'=>$request->module_id])->update($update_data);
            return jsonResponse(TRUE)->message(__('Route permission added successfully.'));

        }catch (\Exception $exception){
            return jsonResponse(TRUE)->message($exception->getMessage());
        }
    }



}
