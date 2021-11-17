<?php

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

function adminAsset($path = '') {
    return asset('admin/' . $path);
}

function webAsset($path = '') {
    return asset('web/' . $path);
}

function getUserAvatar($user) {
    if(!empty($user)){
        $image = $user->profile_photo_path;
        $social_image = $user->social_image_url;
        if(!empty($social_image)){
            return $social_image;
        }else{
            $image_path = public_path('admin/images/users').'/'.$image;
            if($image != NULL && file_exists($image_path)){
                return adminAsset('images/users').'/'.$image;
            }else {
                return adminAsset('images/users/avatar.png');
            }
        }
    }else{
        return adminAsset('images/users/avatar.png');
    }
}



/**
 * Upload file in public Dir
 *
 * @param $new_file
 * @param $path
 * @param null $file_name
 * @param null $width
 * @param null $height
 *
 * @return bool|string
 */
function uploadImage($new_file, $path, $file_name = NULL, $width = NULL, $height = NULL) {
    if (!file_exists(public_path($path))) {
        mkdir(public_path($path), 0777, TRUE);
    }
    $input['image_name'] = ($file_name == NULL ? uniqid().time() : explode('.', $file_name)[0]) . '.' . $new_file->getClientOriginalExtension();

    $imgPath = public_path($path . $input['image_name']);

    $makeImg = Image::make($new_file);

    if ($width != NULL && $height != NULL && is_int($width) && is_int($height)) {
        $makeImg->resize($width, $height);
        $makeImg->fit($width, $height);
    }

    if ($makeImg->save($imgPath)) {
        return $input['image_name'];
    }
    return FALSE;
}
function uploadImageByCamera($new_file, $path, $file_name = NULL, $width = NULL, $height = NULL) {
    if (!file_exists(public_path($path))) {
        mkdir(public_path($path), 0777, TRUE);
    }
    $input['image_name'] = ($file_name == NULL ? uniqid().time() : explode('.', $file_name)[0]) . '.' . 'png';

    $imgPath = public_path($path . $input['image_name']);

    $makeImg = Image::make($new_file);

    if ($width != NULL && $height != NULL && is_int($width) && is_int($height)) {
        $makeImg->resize($width, $height);
        $makeImg->fit($width, $height);
    }

    if ($makeImg->save($imgPath)) {
        return $input['image_name'];
    }
    return FALSE;
}

function quickRandom($length = 16) {
    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
}

function uploadFile($file, $directory, $filename = NULL){
    $upload_path = public_path($directory);
    if (!is_dir($upload_path)) {
        mkdir($upload_path, 0777, true);
    }
    if($filename != NULL){
        $newfilename = $filename.'.'.$file->getClientOriginalExtension();
    }else{
        $newfilename = quickRandom().'.'.$file->getClientOriginalExtension();
    }
    $file->move($upload_path, $newfilename);

    return $newfilename;
}

/**
 * @param $path
 * @param $file_name
 */
function deleteImageFile($path, $file_name) {
    try {
        if (file_exists($path . substr($file_name, strrpos($file_name, '/') + 1))) {
            unlink($path . '/' . substr($file_name, strrpos($file_name, '/') + 1));
        }
    }catch (\Exception $exception){

    }
}

function deleteOnlyImage($path, $file_name){
    try{
        if (file_exists($path . $file_name)) {
            unlink($path . $file_name);
        }
    }catch(\Exception $exception){

    }
}


function uploadStorageFile($destinationPath, $file, $disk = 'admin_image'){
    if ($file != NULL) {
        if($disk == ''){
            Storage::put($destinationPath,$file);
        }else{
            Storage::disk($disk)->put($destinationPath , $file);
        }
    }
}


/**
 * Delete file from storage according to env settings
 *
 * @param $destinationPath
 * @param $file
 * @param string $disk
 */
function deleteStorageFile($destinationPath, $file, $disk = '') {
    try {
        if ($file != NULL) {
            if($disk == ''){
                Storage::delete($destinationPath . $file);
            }else{
                Storage::disk($disk)->delete($destinationPath . $file);
            }
        }
    } catch (Exception $e) {

    }
}

function get_image_path($type = 'user') {
    if ($type == 'user') {
        return 'admin/images/users/';
    }elseif ($type == 'delivery') {
        return 'admin/images/products/delivery/';
    } else if ($type == 'brand') {
        return 'admin/images/products/brand/';
    } else if ($type == 'category') {
        return 'admin/images/products/category/';
    } else if ($type == 'settings') {
        return 'admin/images/application/settings/';
    } else if ($type == 'quotation') {
        return 'admin/images/crm/quotations/';
    }else if ($type == 'auction_message'){
        return 'admin/images/auction/messages/';
    }else{
        return 'admin/images/'.$type;
    }
}

function get_web_image_path($path){
    return 'web/images/'.$path.'/';
}

function storage_logs() {
    return storage_path() . '/logs/';
}

function check_image_exists($path='', $image=''){
    if (!empty($image) && file_exists(public_path($path.'/'.$image))) {
       return asset($path.'/'.$image);
    }else{
        return adminAsset('images/no-image.jpg');
    }
}
function check_storage_image_exists($image=''){
    if (Storage::exists($image)) {
        return Storage::url($image);
    }else{
        return adminAsset('images/no-image.jpg');
    }

}

function getUserProfileImage(){
    $user = User::where('id',\Illuminate\Support\Facades\Auth::user()->id)->first();
    if ($user->is_social_login == TRUE){
        $user_image = !empty($user->profile_photo_path) ? asset(get_image_path('user').$user->profile_photo_path) : $user->social_image_link;
    }else{
        $user_image = !empty($user->profile_photo_path) ? asset(get_image_path('user').$user->profile_photo_path) : '';
    }
    return $user_image;
}

