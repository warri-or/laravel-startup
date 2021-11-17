<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\ForgetPasswordRequest;
use App\Http\Requests\Api\Auth\ForgotPasswordResetRequest;
use App\Http\Requests\Web\Auth\LoginRequest;
use App\Http\Requests\Web\Auth\RegistrationRequest;
use App\Http\Requests\Web\Auth\SellerRequest;
use App\Http\Services\Api\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $service){
        $this->authService = $service;
    }

    public function login(LoginRequest $request){
        return $this->authService->login($request);
    }

    public function register(RegistrationRequest $request){
        return $this->authService->register($request->all());
    }


    public function userVerifyEmail(Request $request){
        return $this->authService->userVerifyEmail($request->code);
    }

    public function sendForgetPasswordMail(ForgetPasswordRequest $request){
        return $this->authService->sendForgetPasswordMail($request);
    }

    public function updatePassword(ForgotPasswordResetRequest $request){
        return $this->authService->updatePassword($request->all());
    }

    public function logOutApi(Request $request){
        return $this->authService->logOut($request);
    }

}
