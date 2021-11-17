<?php

use App\Models\Role\Role;
use App\Models\Role\RoleRoute;
use Illuminate\Support\Facades\Auth;

/***********************************************************************************/
/***********************************************************************************/
/****************** ROUTING AND MENU ***********************/

/**
 * @param $module_to_check
 *
 * @return bool
 */
function check_module_permission($module_to_check) {
    $user_module_id = Auth::user()->default_module_id;
    if ($user_module_id == MODULE_SUPER_ADMIN){
        return TRUE;
    }else{
        $user_role = Auth::user()->role;
        $user_module = \App\Models\RoleRoutePermission::where('role_id',$user_role)->pluck('module_id')->toArray();
        $module_to_check = (int) $module_to_check;

        if (in_array($module_to_check, $user_module)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}

function check_role($role_to_check) {
    $user_role_id = Auth::user()->role;
    $response = FALSE;
    foreach (ROLES as $role_id => $role_name){
        if ($role_to_check == $role_id) {
            if($user_role_id === $role_id){
                $response = TRUE;
                break;
            }
        }
    }
    return $response;
}

/**
 * @param $route_name
 * @param bool $admin_permission
 *
 * @return bool
 */
function check_route_permission($route_name): bool {
    $route_for_all = ["profile","viewAllNotifications"];
    if (in_array($route_name,$route_for_all)) {
        return TRUE;
    }
    if (Auth::user()->default_module_id == MODULE_SUPER_ADMIN) {
        return TRUE;
    } else {
        $action = RoleRoute::where('url', $route_name)->first();
        $role = Role::where('id', Auth::user()->role)->first();

        $role_route_mapping = \App\Models\RoleRoutePermission::where('role_id',$role->id)->get();
        $permitted_routes = [];
        if (isset($role_route_mapping)){
            foreach ($role_route_mapping as $role_route){
                if (!empty($role_route->routes)){
                    $permitted_routes = array_merge($permitted_routes,explode('|', $role_route->routes));
                }
            }
        }
        if (isset($action) && in_array($action->id, $permitted_routes)){
            return TRUE;
        }else{
            return FALSE;
        }

    }
}
/**
 * @param $route_name
 * @param $menu_title
 * @param string $menu_icon
 *
 * @param string $submenu
 * @param string $submenu_to_compare
 * @param bool $admin_permission
 *
 * @return string
 */
function menuLiAppend($route_name, $menu_title, $menu_icon='fas fa-align-right', $submenu = '', $submenu_to_compare = '', $badge_class = NULL): string {
    $html = '';
    if(substr($route_name, 0, 1 ) !== "#"){
        if(check_route_permission($route_name)){
            $submenu_to_compare = $submenu_to_compare != '' ? $submenu_to_compare : $route_name;
            $li_a_active = !empty($submenu) && $submenu == $submenu_to_compare ? 'menuitem-active' : '';
            $a_active = !empty($submenu) && $submenu == $submenu_to_compare ? 'active' : '';
            $html .= '<li class="nav-item '.$li_a_active.'">';
            $html .= '<a class="nav-link '.$a_active.'" href="'. route($route_name) .'">';
            $html .= '<i class="'. $menu_icon .'"></i> '. __($menu_title);

            if(!is_null($badge_class)){
                $html .= '<span class="badge '.$badge_class.' float-right">0</span>';
            }

            $html .= '</a>';
            $html .= '</li>';
        }
    }else{
        $html .= '<li class="nav-item">';
        $html .= '<a class="nav-link" href="'.$route_name.'">';
        $html .= '<i class="'. $menu_icon .'"></i> '. __($menu_title);
        $html .= '</a>';
        $html .= '</li>';
    }
    return $html;
}

/**
 * @param $route_name
 * @param $menu_title
 * @param string $menu_icon
 * @param string $menu
 * @param string $menu_to_compare
 * @param array $module_permission
 *
 * @return string
 */
function mainMenuAppend($route_name, $menu_title, $menu_icon='fas fa-align-right 2x', $menu = '', $menu_to_compare = '',$module_permission=[]): string {
    $html = '';
    $permitted = FALSE;
    $is_active = !empty($menu) && $menu == $menu_to_compare ? 'active' : '';
    if(substr($route_name, 0, 1 ) === "#"){
        if(!empty($module_permission)){
            foreach ($module_permission as $module_id){
                if(check_module_permission($module_id) == TRUE) {
                    $permitted = TRUE;
                    break;
                }
            }
            if($permitted){
                $html .= generateMainMenuLink($is_active, $route_name, $menu_title, $menu_icon);
            }
        }else{
            $html .= generateMainMenuLink($is_active, $route_name, $menu_title, $menu_icon);
        }
    }else{
        $route_name = route($route_name);
        $html .= generateMainMenuLink($is_active, $route_name, $menu_title, $menu_icon);
    }
    return $html;
}

/**
 * @param $is_active
 * @param $route_name
 * @param $menu_title
 * @param $menu_icon
 *
 * @return string
 */
function generateMainMenuLink($is_active, $route_name, $menu_title, $menu_icon): string {
    $html = '';
    $html .= '<a class="nav-link '. $is_active .'" href="'.$route_name.'"';
    $html .= 'data-plugin="tippy" data-tippy-followCursor="true" data-tippy-arrow="true" data-placement="right" data-tippy-animation="fade"';
    $html .= 'title="'.$menu_title.'">';
    $html .= '<i class="'.$menu_icon.'"></i>';
    $html .= '</a>';
    return $html;
}

/****************** END OF ROUTING AND MENU ************************/
