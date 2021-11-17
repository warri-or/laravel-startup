<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    private $authService;
    public function __construct(AuthService $service) {
        $this->authService = $service;
        $settings = __options(['social_login_settings']);
        if (isset($settings->facebook_login) && $settings->facebook_login == ACTIVE){
            config(['service.facebook.client_id' => $settings->facebook_app_id ?? env('FACEBOOK_APP_ID')]);
            config(['service.facebook.client_secret' => $settings->facebook_app_secret ?? env('FACEBOOK_APP_SECRET')]);
            config(['service.facebook.redirect' => $settings->facebook_redirect_url ?? env('FACEBOOK_REDIRECT')]);
        }
        if (isset($settings->google_login) && $settings->google_login == ACTIVE){
            config(['service.google.client_id',$settings->google_app_id ?? env('GOOGLE_CLIENT_ID')]);
            config(['service.google.client_secret',$settings->google_app_secret ?? env('GOOGLE_CLIENT_SECRET')]);
            config(['service.google.redirect',$settings->google_redirect_url ?? env('GOOGLE_REDIRECT')]);
        }
        if (isset($settings->linkedin_login) && $settings->linkedin_login == ACTIVE){
            config(['service.linkedin.client_id',$settings->linkedin_app_id ?? '']);
            config(['service.linkedin.client_secret',$settings->linkedin_app_secret ?? '']);
            config(['service.linkedin.redirect',$settings->linkedin_redirect_url ?? '']);
        }
        if (isset($settings->twitter_login) && $settings->twitter_login == ACTIVE){
            config(['service.twitter.client_id',$settings->twitter_app_id ?? '']);
            config(['service.twitter.client_secret',$settings->twitter_app_secret ?? '']);
            config(['service.twitter.redirect',$settings->twitter_redirect_url ?? '']);
        }
        if (isset($settings->github_login) && $settings->github_login == ACTIVE){
            config(['service.github.client_id',$settings->github_app_id ?? '']);
            config(['service.github.client_secret',$settings->github_app_secret ?? '']);
            config(['service.github.redirect',$settings->github_redirect_url ?? '']);
        }
    }

    public function redirectToProvider($driver) {
        return Socialite::driver($driver)->redirect();
    }

    public function handleProviderCallback($driver) {
        $user = Socialite::driver($driver)->stateless()->user();
        $response = $this->authService->loginWithSocial($user, $driver);
        if ($response->getStatus() == TRUE) {
            if (Auth::user()->default_module_id == MODULE_SUPER_ADMIN){
                return redirect()->intended('admin/super-admin-home')->with(['success'=>__('Login successful as super admin')]);
            }elseif (Auth::user()->default_module_id == MODULE_USER_ADMIN){
                return redirect()->intended('admin/admin-home')->with(['success'=>__('Login successful as admin')]);
            }else{
                Auth::logout();
                return view('auth.login');
            }
        } else {
            Auth::logout();
            return redirect()->route('userLogin')->with(['dismiss' => $response->getMessage()]);
        }
    }
}
