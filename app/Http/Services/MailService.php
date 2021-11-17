<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailService{

    public function __construct() {
        $setting = __options(['email_settings']);
        config(['mail.driver' => $setting->mail_mailer ?? env('MAIL_MAILER')]);
        config(['mail.host' => $setting->mail_host ?? env('MAIL_HOST')]);
        config(['mail.port' => $setting->mail_port ?? env('MAIL_PORT')]);
        config(['mail.username' => $setting->mail_username ?? env('MAIL_USERNAME')]);
        config(['mail.password' => $setting->mail_password ?? env('MAIL_PASSWORD')]);
        config(['mail.encryption' => $setting->mail_encryption ?? env('MAIL_ENCRYPTION')]);
        config(['mail.from.address' => $setting->mail_from_address ?? env('MAIL_FROM_ADDRESS')]);
        config(['mail.from.name' => $setting->mail_from_name ?? env('MAIL_FROM_NAME')]);
    }

    public function sendMailProcess($template,$body,$email,$subject){
        try {
            Mail::send($template, ['body' => $body], function ($messages) use ($email, $subject) {
                $messages->to($email)->subject($subject);
            });
        }catch (\Exception $exception){
            Log::info($exception->getMessage());
        }
    }
}
