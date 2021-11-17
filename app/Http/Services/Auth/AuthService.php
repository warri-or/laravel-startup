<?php

namespace App\Http\Services\Auth;

use App\Http\Repositories\Auth\AuthRepository;
use App\Http\Requests\Web\Auth\ForgetPasswordRequest;
use App\Http\Services\MailService;
use App\Jobs\SendMailJob;
use App\Models\User;
use App\Models\UserVerificationCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthService
{
    /**
     * Instantiate repository
     *
     * @param Auth/AuthRepository $repository
     */
    public function __construct(AuthRepository $repository)
    {
        $this->repo = $repository;
    }

    // Your methods for repository

    public function login(Request $request){

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return $this->statusCheck(auth()->user());
        } else {
            return jsonResponse(FALSE)->message(__('Email or Password Not matched!'));
        }
    }

    public function loginWithSocial($user,$driver){
        if ($driver == 'facebook'){
            return $this->socialLoginAttempt($user,'fb_id');
        }elseif ($driver == 'google'){
            return $this->socialLoginAttempt($user,'google_id');
        }elseif ($driver == 'linkedin'){
            return $this->socialLoginAttempt($user,'linkedin_id');
        }elseif ($driver == 'twitter'){
            return $this->socialLoginAttempt($user,'twitter_id');
        }elseif ($driver == 'github'){
            return $this->socialLoginAttempt($user,'github_id');
        }
    }

    private function socialLoginAttempt($user,$driver_key){
        $isUser = User::where('email',$user->email)->first();
        if($isUser){
            Auth::login($isUser);
            return $this->statusCheck(auth()->user());
        }else{
            $createUserData = [
                'name' => $user->name,
                'email' => $user->email,
                'is_social_login' => TRUE,
                'social_image_url' => $user->avatar,
                $driver_key => $user->id,
                'password' => bcrypt('Pass.123456'),
                'remember_token' => md5($user->email. uniqid() . randomString(5)),
                'email_verified' => TRUE,
                'default_module_id' => MODULE_USER,
                'role' => USER,
                'status' => ACTIVE
            ];
            $createUser = User::create($createUserData);
            Auth::login($createUser);
            return jsonResponse(true)->message(__('Login successful'));
        }
    }

    public function statusCheck($user){
        if ($user->status == ACTIVE){
            return jsonResponse(TRUE)->message(__('Login successful.'));
        }elseif ($user->status == INACTIVE) {
            Auth::logout();
            return jsonResponse(FALSE)->message(__('Your account is inactive. Please change your password or contact with admin.'));
        }elseif ($user->status == STATUS_BLOCKED){
            Auth::logout();
            return jsonResponse(FALSE)->message(__('You are blocked. Contact with admin.'));
        } elseif ($user->status == STATUS_SUSPENDED) {
            Auth::logout();
            return jsonResponse(FALSE)->message(__('Your Account has been suspended. please contact with admin to active again!'));
        }else{
            Auth::logout();
            return jsonResponse(FALSE)->default();
        }
    }

    public function register(array $requestArray){
        DB::beginTransaction();
        try {
            $user = User::create($this->getRegistrationData($requestArray));
            if (isset($user)) {
                $this->sendUserVerificationMail($user);
            }
            DB::commit();
            return jsonResponse(TRUE)->message(__('Registration successful.Please verify your email to login.'));
        }catch (\Exception $exception){
            DB::rollBack();
            return jsonResponse(FALSE)->message($exception->getMessage());
        }
    }

    private function getRegistrationData(array $requestArray){
        $user_data =[
            'name' => $requestArray['name'],
            'email' => $requestArray['email'],
            'module_id' => MODULE_USER,
            'role' => USER,
            'password' => bcrypt($requestArray['password']),
            'remember_token' => md5($requestArray['email'] . uniqid() . randomString(5)),
            'status' => INACTIVE
        ];
        return $user_data;
    }

    public function sendUserVerificationMail($user) {
        $mail_key = randomNumber(6);
        $insert_code = [
            'user_id' => $user->id,
            'code' => $mail_key,
            'type' => 1,
            'status' => INACTIVE,
            'expired_at' => date('Y-m-d', strtotime('+15 days'))
        ];
        UserVerificationCode::create($insert_code);
        $userName = $user->name;
        $userEmail = $user->email;
        $subject = env('APP_NAME').__(' Email Verification.');
        $userData['message'] = __('Hello! ') . $userName . __(' Please Verify Your Email.');
        $userData['verification_code'] = $mail_key;
        $userData['email'] = $userEmail;
        $userData['name'] = $userName;
        dispatch(new SendMailJob('admin.mail.email.send_verification_mail_web', $userEmail, $userData, $subject));
    }

    public function userVerifyEmail($code){
        if (!empty($code)) {
            $user_verification = UserVerificationCode::where(['code' => $code])->first();
            if ($user_verification) {
                DB::beginTransaction();
                try {
                    UserVerificationCode::where(['id' => $user_verification->id])->update(['status' => ACTIVE]);
                    $user = User::where('id',$user_verification->user_id)->first();
                    if (!empty($user)) {
                        if ($user->email_verified == INACTIVE) {
                            User::where('id',$user->id)->update(['email_verified' => ACTIVE, 'status' => ACTIVE]);
                            $response = jsonResponse(TRUE)->message(__('Email successfully verified.'));
                        } else {
                            $response = jsonResponse(TRUE)->message(__('You already verified email!'));
                        }
                    } else {
                        $response = jsonResponse(FALSE)->message(__('Email Verification Failed'));
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    $response =  jsonResponse(FALSE)->message($e->getMessage());
                }
            } else {
                $response =  jsonResponse(FALSE)->message(__('Verification Code Not Found!'));
            }
            return $response;
        }else{
            return jsonResponse(FALSE)->message(__('Verification Code Not Found!'));
        }
    }

    public function sendForgetPasswordMail($request) {
        try {
            $user = User::where(['email' => $request->email])->first();
            if ($user) {
                 $this->repo->sendForgotPasswordMail($user);
                 $data['user'] = $user;
                 return jsonResponse(true)->message(__("Please check your email to recover password."))->data($data);
            } else {
                return jsonResponse(FALSE)->message(__("Your email is not correct!."));
            }
        } catch (\Exception $e) {
            return jsonResponse(FALSE)->default();
        }
    }

    public function changePassword(Request $request){
        try {
            $user = User::where(['remember_token' => $request->remember_token])->first();
            if ($user) {
                $updated = $this->repo->changePassword($user,$request->password);
                if ($updated) {
                    if ($user->status == INACTIVE){
                        $this->repo->changeStatus($user,ACTIVE);
                    }
                    $data['user'] = $user;
                    return jsonResponse(true)->message(__("Password changed successfully."))->data($data);
                } else {
                    return jsonResponse(FALSE)->message(__("Password not changed try again."));
                }
            } else {
                return jsonResponse(FALSE)->message(__("Sorry! user not found."));
            }
        } catch (\Exception $e) {
            return jsonResponse(FALSE)->default();
        }
    }

    public function logOut(Request $request){
        try {
            if (Auth::check()) {
                Auth::user()->AauthAcessToken()->delete();
                return jsonResponse(TRUE)->message(__('Logout successful!'));
            }else{
                return jsonResponse(FALSE)->message(__('You are not authenticated!'));
            }
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->message($exception->getMessage());
        }

    }
}
