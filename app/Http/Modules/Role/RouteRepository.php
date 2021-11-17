<?php

namespace App\Http\Modules\Role;
use App\Models\Role\RoleRoute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RouteRepository
{
    // Your methods for repository

    public function updateRouteList(){
        $route_data = Storage::disk('public')->get('routes.json');
        $route_data = json_decode($route_data);
        $role_routes = [];
        foreach (RoleRoute::all(['url']) as $value){
            $role_routes[] = $value->url;
        }
        DB::transaction(function () use ($role_routes, $route_data) {
            foreach ($route_data as $routes){
                if(in_array($routes->url, $role_routes)){
                    RoleRoute::where('url',$routes->url)->update(['name'=>ucfirst($routes->name),'module_id'=>$routes->module_id]);
                }else{
                    RoleRoute::create(['name'=>ucfirst($routes->name), 'url'=>$routes->url,'module_id'=>$routes->module_id]);
                }
            }
        });
        return TRUE;
    }
}
