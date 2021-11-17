<?php

namespace App\Http\Modules\Notification;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function showNewNotification(Request $request){
        if ($request->ajax()) {
            $data['new_notifications'] = Notification::where(['user_id'=>Auth::user()->id,'is_cleared'=>0])->orderBy('id','desc')->limit(10)->get();
            return jsonResponse(TRUE)->message(__('Notification get successfully'))->data($data);
        }
    }

    public function clearAllNotification(){
        try {
            Notification::where('user_id',Auth::user()->id)->update(['is_cleared'=>TRUE,'status'=>ACTIVE]);
            return jsonResponse(TRUE)->message(__('Notification cleared successfully'));
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->default();
        }
    }

    public function makeNotificationRead(Request $request){
        try {
            Notification::where('id',$request->id)->update(['status'=>ACTIVE]);
            return jsonResponse(TRUE)->message(__('Notification make read successfully'));
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->default();
        }
    }

    public function viewAllNotifications(Request $request){
        if ($request->ajax()) {
            $notifications = Notification::where('user_id',Auth::user()->id)->get();
            return datatables($notifications)
                ->editColumn('user_image',function ($item){
                    $user = json_decode($item->body);
                    $user_image = !empty($user->user_image) ? asset(get_image_path('user').'/'.$user->user_image) : adminAsset('images/users/avatar.png');
                    return '<img src="'.$user_image.'" class="img-circle" width="50">';
                })->editColumn('username',function ($item){
                    $user = json_decode($item->body);
                    return $user->username;
                })->editColumn('notification',function ($item){
                    $user = json_decode($item->body);
                    $html =  '<span>'.$user->title.'</span><br>';
                    $html .=  '<span>'.$user->body.'</span><br>';
                    return $html;
                }) ->editColumn('action',function ($item){
                    $html ='<a href="javascript:void(0)" class="text-danger p-1 delete_item" data-style="zoom-in" data-id="'.$item->id.'"><i class="fa fa-trash"></i></a>';
                    return $html;
                })->rawColumns(['user_image','notification','action'])
                  ->make(TRUE);
        }
        return  view('admin.notification.view_all_notification');
    }

    public function deleteNotification(Request $request){
        try {
            Notification::where('id',$request->id)->delete();
            return jsonResponse(TRUE)->message(__('Notification deleted successfully'));
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->default();
        }
    }
}
