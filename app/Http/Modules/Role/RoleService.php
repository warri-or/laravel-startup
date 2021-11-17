<?php


namespace App\Http\Modules\Role;

use App\Http\Boilerplate\CustomResponse;
use App\Models\Role\Role;
use App\Models\Role\RoleRoute;
use App\Models\RoleRoutePermission;

class RoleService {

    public function getRoleData($id){
        $data['role'] = Role::where('id',$id)->first();
        $data['role_module'] = RoleRoutePermission::where('role_id',$data['role']->id)->pluck('module_id')->toArray();
        return $data;
    }


    /**
     * @param array $data
     *
     * @return CustomResponse|mixed|string
     */
    public function create(array $data) {
        try {
            $insert_data['title'] = $data['title'];
            $response = Role::create($insert_data);
            if ($response){
                $this->insertRoleModule($response->id, $data['module_id']);
            }
            return is_null($response) ?
                jsonResponse(false)->message(__('Role create failed')) :
                jsonResponse(true)->message(__('Role has been created successfully'));
        } catch (\Exception $e) {
            return jsonResponse(false)->message($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @param array $data
     *
     * @return CustomResponse|mixed|string
     */
    public function update(int $id, array $data) {
        try {
            $update_data['title'] = $data['title'];
            $response = Role::where('id',$id)->update($update_data);
            $this->updateRoleModule($id, $data['module_id']);
            return jsonResponse(true)->message(__('Role has been updated successfully'));
        } catch (\Exception $e) {
            return jsonResponse(false)->default();
        }
    }

    private function insertRoleModule($role_id,$module_id){
        $insert_role_module = [];
        if (!empty($module_id)){
            foreach ($module_id as $key=>$value){
                $insert_role_module[$key]['role_id'] = $role_id;
                $insert_role_module[$key]['module_id'] = $value;
                $insert_role_module[$key]['status'] = ACTIVE;
            }
        }
        RoleRoutePermission::insert($insert_role_module);
    }

    private function updateRoleModule($role_id,$module_id){
        $existing_module_id = RoleRoutePermission::where('role_id',$role_id)->pluck('module_id')->toArray();
        $deletable_module_id = array_diff($existing_module_id,$module_id);
        RoleRoutePermission::where(['role_id'=>$role_id])->whereIn('module_id',$deletable_module_id)->delete();
        if (($key = array_search($deletable_module_id, $existing_module_id)) !== false) {
            unset($existing_module_id[$key]);
        }
        if (!empty($existing_module_id)){
            foreach ($existing_module_id as $value){
                if (($key = array_search($value, $module_id)) !== false) {
                    unset($module_id[$key]);
                }
            }
        }
        $insert_role_module = [];
        if (!empty($module_id)){
            $index = 0;
            foreach ($module_id as $value){
                $insert_role_module[$index]['role_id'] = $role_id;
                $insert_role_module[$index]['module_id'] = $value;
                $insert_role_module[$index]['status'] = ACTIVE;
                $index ++ ;
            }
            RoleRoutePermission::insert($insert_role_module);
        }
    }

    public function delete($id){
        try {
            $response = Role::where('id',$id)->delete();
            if ($response){
                return jsonResponse(TRUE)->message('Role deleted successfully.');
            }else{
                return jsonResponse(TRUE)->message('Role delete failed.');
            }
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->default();
        }

    }
}
