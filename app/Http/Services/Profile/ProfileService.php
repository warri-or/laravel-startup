<?php

namespace App\Http\Services\Profile;

use App\Http\Repositories\Profile\ProfileRepository;
use App\Http\Services\BaseService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileService extends BaseService
{
    /**
     * Instantiate repository
     *
     * @param Profile/ProfileRepository $repository
     */
    public function __construct(ProfileRepository $repository)
    {
        $this->repo = $repository;
    }

    // Your methods for repository

    public function updateProfile($id,array $requestArray){
        try {
            $user = User::where('id',$id)->first();
            $update_data = $this->prepareProfileUpdateData($requestArray, $user);
            $response = $this->repo->update($id,$update_data);
            if ($response){
                return jsonResponse(true)->message(__("Profile updated successfully."));
            }else{
                return jsonResponse(FALSE)->message(__("Profile update failed."));
            }
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->message($exception->getMessage());
        }

    }

    private function prepareProfileUpdateData($requestArray,$user){
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

    private function imageData($image,$id=NULL){
        if ($id !== NULL){
            $details =  $this->repo->firstWhere(['id'=>$id]);
            return uploadImage($image,get_image_path('user'),$details->profile_photo_path ?? '');
        }else{
            return uploadImage($image,get_image_path('user'));
        }
    }
    public function updatePassword($id,$new_password,$old_password){
        try {
            if (Hash::check($old_password,Auth::user()->password)){
                $data['password'] = bcrypt($new_password);
                $response = $this->repo->update($id,$data);
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
}
