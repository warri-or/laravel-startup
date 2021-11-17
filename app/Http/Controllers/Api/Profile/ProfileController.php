<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\Profile\PasswordUpdateRequest;
use App\Http\Services\Profile\PaymentOptionService;
use App\Http\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    private $user_service,$payment_option_service;
    public function __construct(UserService $user_service,PaymentOptionService $payment_option_service){
        $this->user_service = $user_service;
        $this->payment_option_service = $payment_option_service;
    }
    public function myProfile(){
        return $this->user_service->getUserDetails(Auth::user()->id);
    }

    public function myEarnings(){
        return $this->user_service->myEarnings(Auth::user()->id);
    }

    public function updateProfile(Request $request){
        return $this->user_service->update(Auth::user()->id,$request->all());
    }
    public function updateProfilePicture(Request $request){
        return $this->user_service->updateProfilePicture($request->all());
    }

    public function updatePassword(PasswordUpdateRequest $request){
        return $this->user_service->updatePassword($request->all());
    }

    public function myPaymentOption(){
        return $this->payment_option_service->getUserPaymentOption(Auth::user()->id);
    }

    public function addPaymentOption(Request $request){
        if (!empty($request->id)) {
            return $this->payment_option_service->update($request->id,$request->except('id'));
        }else{
            return $this->payment_option_service->create($request->except('id'));
        }
    }
}
