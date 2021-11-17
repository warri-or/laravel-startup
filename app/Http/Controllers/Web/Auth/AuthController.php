<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\ForgetPasswordRequest;
use App\Http\Requests\Web\Auth\ForgotPasswordResetRequest;
use App\Http\Requests\Web\Auth\LoginRequest;
use App\Http\Requests\Web\Auth\RegistrationRequest;
use App\Http\Services\Auth\AuthService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $authService;

    /**
     * SupplierController constructor.
     *
     * @param AuthService $service
     */
    public function __construct(AuthService $service){
        $this->authService = $service;
    }
    public function login() {
        if (Auth::user()) {
            if (Auth::user()->default_module_id == MODULE_SUPER_ADMIN){
                return redirect()->route('superAdminHome');
            }elseif (Auth::user()->default_module_id == MODULE_USER_ADMIN){
                return redirect()->route('adminHome');
            }else{
                Auth::logout();
                return view('auth.login');
            }
        } else {
            return view('auth.login');
        }
    }

    // Login post
    public function postLogin(LoginRequest $request) {
        $response = $this->authService->login($request);
        if ($response->getStatus() == TRUE){
            if (Auth::user()->default_module_id == MODULE_SUPER_ADMIN){
                 return redirect()->intended('admin/super-admin-home')->with(['success'=>__('Login successful as super admin')]);
            }elseif (Auth::user()->default_module_id == MODULE_USER_ADMIN){
                return redirect()->intended('admin/admin-home')->with(['success'=>__('Login successful as admin')]);
            }else{
                Auth::logout();
                return view('auth.login');
            }
        }else{
            Auth::logout();
            return redirect()->route('login')->with(['dismiss'=>$response->getMessage()]);
        }
    }

    public function postLoginModal(LoginRequest $request) {
        return $this->authService->login($request);
    }

    public function userRegister($type=NULL){
        $data['type'] = $type;
        return view('web.auth.sign_up',$data);
    }

    public function userRegistrationSave(RegistrationRequest $request){
        $response = $this->authService->register($request->all());
        if ($response->getMessage() == TRUE){
            return redirect()->route('userLogin')->with(['success'=>$response->getMessage()]);
        }else{
            return redirect()->route('userLogin')->with(['dismiss'=>$response->getMessage()]);

        }
    }

    public function userRegistrationModal(RegistrationRequest $request){
        return $this->authService->register($request->all());
    }

    public function userVerifyEmail($code){
        $code = decrypt($code);
        $response = $this->authService->userVerifyEmail($code);
        if ($response->getMessage() == TRUE){
            return redirect()->route('userLogin')->with(['success'=>$response->getMessage()]);
        }else{
            return redirect()->route('userLogin')->with(['dismiss'=>$response->getMessage()]);

        }
    }

    //---- done
    public function userLogOut(Request $request) {
        $request->session()->flush();
        Auth::logout();
        return redirect()->to('/');
    }
    public function logout(Request $request) {
        $request->session()->flush();
        Auth::logout();
        return redirect()->route('login');
    }

    public function forgetPassword() {
        return view('auth.forgot-password');
    }

    public function sendForgetPasswordMail(ForgetPasswordRequest $request) {
        $response = $this->authService->sendForgetPasswordMail($request);
        if ($response->getStatus() == TRUE) {
            return redirect()->route('login')->with('success', $response->getMessage());
        } else {
            return redirect()->back()->with('dismiss', $response->getMessage());
        }
    }

    public function resetPassword($reset_code){
        $remember_token = decrypt($reset_code);
        $data['remember_token'] = $remember_token;
        return view('auth.reset-password', $data);
    }

    public function changePassword(ForgotPasswordResetRequest $request){
        $response = $this->authService->changePassword($request);
        if ($response->getStatus() == TRUE) {
            return redirect()->route('login')->with('success', $response->getMessage());
        } else {
            return redirect()->back()->with('dismiss', $response->getMessage());
        }
    }
}
