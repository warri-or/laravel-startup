<?php

namespace App\Http\Services\Api\Auth;
use App\Http\Repositories\Api\Auth\AuthRepository;
use App\Jobs\SendMailJob;
use App\Models\User;
use App\Models\UserVerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login(Request $request){
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::where('id',Auth::user()->id)->first();
            $status = $this->statusCheck($user);
            if ($status->getStatus() == TRUE){
                $token_info = $this->accessTokenProcess($user, $request);
                $user_data = [
                    'user' => $user,
                    'access_token'   => $token_info['access_token'],
                ];
                return jsonResponse(TRUE)->message(__('User get successfully!'))->data($user_data);
            }else{
                return jsonResponse(FALSE)->message($status->getMessage());
            }
        } else {
            return jsonResponse(FALSE)->message(__('Email or Password Not matched!'));
        }
    }

    public function statusCheck($user){
        if ($user->status == ACTIVE){
            return jsonResponse(TRUE)->message(__('Login successful.'));
        }elseif ($user->status == INACTIVE) {
            Auth::logout();
            return jsonResponse(FALSE)->message(__('Your account is inactive. Please change your password or contact with admin.'));
        }
        elseif ($user->status == USER_BLOCKED){
            Auth::logout();
            return jsonResponse(FALSE)->message(__('You are blocked. Contact with admin.'));
        } elseif ($user->status == USER_SUSPENDED) {
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
            'nid' => $requestArray['nid'] ?? '',
            'is_seller' => $requestArray['is_seller'] ?? IS_USER,
            'default_module_id' => MODULE_USER,
            'role' => isset($requestArray['is_seller']) && $requestArray['is_seller'] == IS_USER ? USER_BIDDER  : USER_SELLER,
            'password' => bcrypt($requestArray['password']),
            'remember_token' => md5($requestArray['email'] . uniqid() . randomString(5)),
            'status' => INACTIVE
        ];
        if (isset($requestArray['nid_picture'])){
            $user_data['nid_picture'] = uploadImage($requestArray['nid_picture'], get_image_path('user'));
        }
        if (isset($requestArray['profile_photo_path'])){
            $user_data['profile_photo_path'] = uploadImage($requestArray['profile_photo_path'], get_image_path('user'));;
        }
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
        $subject = __('Home Deeler Email Verification.');
        $userData['message'] = __('Hello! ') . $userName . __(' Please Verify Your Email.');
        $userData['verification_code'] = $mail_key;
        $userData['email'] = $userEmail;
        $userData['name'] = $userName;
        dispatch(new SendMailJob('admin.mail.email.send_verification_mail_api', $userEmail, $userData, $subject));
    }

    public function sendForgetPasswordMail($request) {
        try {
            $user = User::where(['email' => $request->email])->first();
            if ($user) {
                $this->sendMail($user);
                return jsonResponse(true)->message(__("Please check your email to recover password."));
            } else {
                return jsonResponse(FALSE)->message(__("Your email is not correct!."));
            }
        } catch (\Exception $e) {
            return jsonResponse(FALSE)->default();
        }
    }

    private function sendMail($user){
        $userName = $user->name;
        $userEmail = $user->email;
        $subject = __('Forget Password');
        $data['name'] = $userName;
        $reset_password_code = randomNumber(6);
        User::where('id',$user->id)->update(['reset_password_code'=>$reset_password_code]);
        $data['reset_password_code'] = $reset_password_code;
        dispatch(new SendMailJob('admin.mail.email.reset_password_mail_api', $userEmail, $data, $subject));
    }

    public function userVerifyEmail($code){
        if (!empty($code)) {
            $user_verification = UserVerificationCode::where(['code' => $code])->first();
            if ($user_verification) {
                DB::beginTransaction();
                try {
                    UserVerificationCode::where(['id' => $user_verification->id])->update(['status' => STATUS_SUCCESS]);
                    $user = User::where('id',$user_verification->user_id)->first();
                    if (!empty($user)) {
                        if ($user->email_verified == INACTIVE) {
                            User::where('id',$user->id)->update(['email_verified' => STATUS_ACTIVE, 'status' => STATUS_ACTIVE]);
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

    public function updatePassword(array $requestArray){
        try {
            $user = User::where(['reset_password_code' => $requestArray['reset_password_code']])->first();
            if ($user) {
                $updated = $this->changePassword($user,$requestArray['password']);
                if ($updated) {
                    return jsonResponse(true)->message(__("Password changed successfully."));
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

    public function sellerRequestSend(array $requestArray){

        DB::beginTransaction();
        try {
            $user = User::where('id',$requestArray['id'])->first();
            if (isset($user)){
                $requestArray['role'] = USER_SELLER;
                User::where('id',$user->id)->update($requestArray);
                DB::commit();
                return jsonResponse(TRUE)->message(__('Seller request sent.'));
            }else{
                return jsonResponse(FALSE)->message(__('User not found.'));
            }
        }catch (\Exception $exception){
            DB::rollBack();
            return jsonResponse(FALSE)->message($exception->getMessage());
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

    public function accessTokenProcess($user, $request) {
        $data = [];
        $token_data = $user->createToken($request->email)->toArray();
        $data['access_token'] = $token_data['accessToken'];
        $token_attribute = $token_data['token']->toArray();
        $data['access_token_id'] = $token_attribute['id'];
        if ($request->device_token != '') {
            DB::table('oauth_access_tokens')
              ->where('id', $data['access_token_id'])
              ->update(['device_token' => $request->device_token, 'driver' => $request->driver]);
        }
        return $data;
    }

    private function changePassword($user,$new_password){
        $update_password['reset_password_code'] = '';
        $update_password['password'] = Hash::make($new_password);
        return User::where(['id' => $user->id])->update($update_password);
    }
}
