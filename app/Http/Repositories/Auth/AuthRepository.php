<?php

namespace App\Http\Repositories\Auth;


use App\Http\Repositories\BaseRepository;
use App\Http\Services\MailService;
use App\Jobs\SendMailJob;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    // Your methods for repository

    public function getUserByToken($remember_token){
        return User::where(['remember_token' => $remember_token])->first();
    }
    public function changePassword($user,$new_password){
        $update_password['remember_token'] = md5($user->email . uniqid() . randomString(5));
        $update_password['reset_password_code'] = '';
        $update_password['password'] = Hash::make($new_password);
        return User::where(['id' => $user->id])->update($update_password);
    }
    public function changeStatus($user,$status){
        User::where(['id'=>$user->id])->update(['status'=>$status]);
    }

    public function sendForgotPasswordMail($user){
        $userName = $user->name;
        $userEmail = $user->email;
        $subject = __('Forget Password');
        $data['name'] = $userName;
        $remember_token = $user->remember_token;
        User::where('id',$user->id)->update(['remember_token'=>$remember_token]);
        $data['remember_token'] = $remember_token;
        dispatch(new SendMailJob('admin.mail.email.reset_password_mail_web', $userEmail, $data, $subject));
        return TRUE;
    }
}
