<?php

namespace App\Http\Controllers\Web\Admin\SuperAdmin;


use App\Http\Controllers\Controller;
use App\Http\Modules\Notification\NotificationService;
use App\Http\Services\DashboardService;
use Illuminate\Http\Request;


class DashboardController extends Controller {

    public function index(){
        return view('admin.super_admin.dashboard.home');
    }

    public function helloGet(NotificationService $notificationService){
        $trigger_channel = 'test-notification-channel';
        $title = 'Test-notification';
        $event = 'test-notification-event';
        $body = [
            'name'=>'Imtiaz',
            'age'=>'10'
        ];
        $notificationService->triggerNotification($trigger_channel,$event,$title,$body);
        return jsonResponse(true)->message('kkk');
    }
}
