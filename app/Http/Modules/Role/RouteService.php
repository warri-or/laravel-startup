<?php

namespace App\Http\Modules\Role;

use App\Models\Role\RoleRoute;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class RouteService {
    private $repo;
    public function __construct(RouteRepository $repository) {
        $this->repo = $repository;
    }

    // Your methods for repository

    public function updateRouteList() {
        try {
            $response = $this->repo->updateRouteList();
            if ($response) {
                return jsonResponse(TRUE)->message(__("Routing List synced successfully."));
            } else {
                return jsonResponse(FALSE)->message(__("Routing List sync failed."));
            }
        } catch (\Exception $exception) {
            return jsonResponse(FALSE)->message($exception->getMessage());
        }
    }

    public static function generateRouteList() {
        $roles_route = [];
        foreach (RoleRoute::all() as $value) {
            $roles_route[$value->url] = $value->name;
        }
        $routes = Route::getRoutes();
        $admin_routes = [];
        foreach ($routes as $route) {
            $route_middleware = $route->middleware();
            for ($i = 0; $i < count($route_middleware); $i++) {
                if (explode(':', $route_middleware[$i])[0] == 'module_permission') {
                    $admin_routes[] = array(
                        'module_id' => explode(':', $route_middleware[$i])[1],
                        'name'      => isset($role_routes[$route->getName()])
                            ? ucfirst(preg_replace('/(?<!\ )[A-Z]/', ' $0', $role_routes[$route->getName()]))
                            : ucfirst(preg_replace('/(?<!\ )[A-Z]/', ' $0', $route->getName())),
                        'url'       => $route->getName()
                    );
                }
            }
        }

        try {
            Storage::disk('public')->put('routes.json', json_encode($admin_routes));
            return TRUE;
        } catch (\Exception $e) {
            return FALSE;
        }
    }
}
