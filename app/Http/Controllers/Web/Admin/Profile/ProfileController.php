<?php

namespace App\Http\Controllers\Web\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\Profile\PasswordUpdateRequest;
use App\Http\Requests\Web\Admin\Profile\ProfileUpdateRequest;
use App\Http\Requests\Web\Admin\User\UserRequest;
use App\Http\Services\Profile\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $service) {
        $this->profileService = $service;
    }

    public function index(Request $request) {
        $data['profile'] = $this->profileService->firstWhere(['id'=>Auth::user()->id]);
        return view('admin.profile.profile',$data);
    }

    public function updateProfile(Request $request) {
        return $this->profileService->updateProfile($request->id,$request->all());
    }
    public function updatePassword(PasswordUpdateRequest $request) {
        return $this->profileService->updatePassword($request->id,$request->password,$request->old_password);
    }

    public function userAvatarUpdate(Request $request){
        dd($request->all());
    }
}
