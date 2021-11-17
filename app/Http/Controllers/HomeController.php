<?php

namespace App\Http\Controllers;
use App\Http\Services\NotificationService;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function setLang($code){
        $user_lang_update = User::where('id',Auth::user()->id)->update(['language' => $code]);
        App::setLocale($code);
        if ($user_lang_update) {
            return redirect()->back()->with(['success' => __('Language Changed Successfully.')]);
        } else {
            return redirect()->back()->with(['dismiss' => __('Language Change Failed.')]);
        }
    }

    public function triggerTestNotification(){
        $title = 'Test notification title';
        $body = [
            'name' => 'Test 1',
            'role' => 'Admin',
            'description' => 'Some text will be written here'
        ];
        NotificationService::triggerNotification('test_notification','admin_notification',$title,$body);

        return redirect()->back()->with(['success'=>'Test notification sent successfully.']);
    }
}
