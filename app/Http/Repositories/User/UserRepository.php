<?php

namespace App\Http\Repositories\User;

use App\Http\Services\MailService;
use App\Jobs\SendMailJob;
use App\Models\User;
use App\Models\UserBrand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    // Your methods for repository

    public function getUserList(){
           return User::select('users.*','roles.title as role_name')
                          ->leftJoin('roles','users.role','roles.id')
                          ->where('users.id','<>',Auth::user()->id)
                          ->orderBy('users.created_at','desc');
    }


    public function getUserDetails($id){
        return User::where('id',$id)->first();
    }

    public function userPasswordChangeMail($user) {
        if ($user) {
            $userName = $user->name;
            $userEmail = $user->email;
            $subject = __('Home Deeler Password Change Mail');
            $data['name'] = $userName;
            $data['remember_token'] = $user->remember_token;
            dispatch(new SendMailJob('admin.mail.email.reset_password_mail_web', $userEmail, $data, $subject));
        }
    }
}
