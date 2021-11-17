<?php

namespace App\Http\Services\User;

use App\Http\Repositories\User\UserRepository;
use App\Models\Role\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Instantiate repository
     *
     * @param User/UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repo = $repository;
    }

    public function getUserList(){
        return $this->repo->getUserList();
    }

    public function getUserDetails($user_id){
        try {
            $user = User::where(['id'=>$user_id])->first();
            if (!empty($user->profile_photo_path)){
                $user->profile_photo_path = asset(get_image_path().$user->profile_photo_path);
            }
            $data['profile'] = $user;
            return jsonResponse(TRUE)->message(__('My profile data get successfully'))->data($data);
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->default();
        }
    }

    public function getUserData($id){
        if ($id !== NULL){
            $data['user'] = $this->repo->getUserDetails($id);
        }else{
            $data['user'] = [];
        }
        $data['roles'] = Role::all();
        return $data;
    }

    public function create(array $requestArray) {
        try {
            DB::beginTransaction();
            $requestArray['password'] = bcrypt(123456);
            $requestArray['remember_token'] = md5($requestArray['email'] . uniqid() . randomString(5));
            $user = User::create($requestArray);
            if ( $user) {
                $this->repo->userPasswordChangeMail($user);
                DB::commit();
                return jsonResponse(true)->message(__("User been created successfully."));
            }
            DB::rollBack();
            return jsonResponse(false)->message(__("User create failed."));
        } catch (\Exception $e) {
            DB::rollBack();
            return jsonResponse(false)->message($e->getMessage());
        }
    }

    public function update(int $id, array $requestArray) {
        try {
            $update_data = $this->prepareUserProfileData($requestArray);
            $response = User::where('id', $id)->update($update_data);
            return !$response ? jsonResponse(false)->default() :
                jsonResponse(true)->message(__("User has been updated successfully"));
        } catch (\Exception $e) {
            return jsonResponse(false)->message($e->getMessage());
        }
    }

    private function prepareUserProfileData($requestArray){
        $user = Auth::user();
        if (isset($requestArray['profile_photo_path'])){
            if (!empty($user->profile_photo_path)){
                deleteOnlyImage(get_image_path('user'), $user->profile_photo_path);
            }
            $requestArray['profile_photo_path'] = uploadImage($requestArray['profile_photo_path'],get_image_path('user'));
        }
        if (isset($requestArray['nid_picture'])){
            if (!empty($user->nid_picture)){
                deleteOnlyImage(get_image_path('user'), $user->nid_picture);
            }
            $requestArray['nid_picture'] = uploadImage($requestArray['nid_picture'],get_image_path('user'));
        }

        return $requestArray;
    }

    public function userStatusChange(array $requestArray) {
        try {
            User::where('id',$requestArray['id'])->update(['status' => $requestArray['status']]);
            return jsonResponse(TRUE)->message(__('Status changed successful.'));
        } catch (\Exception $exception) {
            return jsonResponse(FALSE)->message(__('Status change failed.'));
        }
    }


    public function updateProfilePicture(array $requestArray) {
        try {
            if (isset($requestArray['profile_photo_path'])){
                $user = Auth::user();
                if (!empty($user->profile_photo_path)){
                    deleteOnlyImage(get_image_path('user'), $user->profile_photo_path);
                }
                $image_name = uploadImage($requestArray['profile_photo_path'],get_image_path('user'));
                User::where('id',$user->id)->update(['profile_photo_path'=>$image_name]);
                return jsonResponse(TRUE)->message(__('Profile picture changed successfully.'));
            }
            return jsonResponse(FALSE)->message(__('Profile picture change failed.'));
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->default();
        }
    }

    public function updatePassword(array $requestArray){
        try {
            if (Hash::check($requestArray['old_password'],Auth::user()->password)){
                $data['password'] = bcrypt($requestArray['password']);
                $response = $this->repo->updateModel(Auth::user()->id,$data);
                if ($response){
                    return jsonResponse(true)->message(__("Password updated successfully."));
                }else{
                    return jsonResponse(false)->message(__("Password update failed."));
                }
            }else{
                return jsonResponse(false)->message(__("Incorrect old password!."));
            }
        }catch (\Exception $exception){
            return jsonResponse(false)->default();
        }
    }

    public function delete($id){
        try {
            $user = User::where('id',$id)->delete();
            if ($user){
                return jsonResponse(TRUE)->message('User deleted successfully.');
            }else{
                return jsonResponse(TRUE)->message('User delete failed.');
            }
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->default();
        }

    }
}
