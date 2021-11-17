<?php

namespace App\Http\Modules\Messaging;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagingController extends Controller
{
    private $messaging_service;
    public function __construct(MessagingService $messaging_service){
        $this->messaging_service = $messaging_service;
    }

    public function messaging(){
        $last_messagae = $this->messaging_service->getLastAdminMessage(Auth::id());
        if (isset($last_messagae)) {
            $data['message'] = $last_messagae;
            $data['message_details'] = $this->messaging_service->getMessageDetails($last_messagae->message_id);
        }
        $data['my_id'] = Auth::user()->id;
        return view('modules.messaging.admin.messaging',$data);
    }

    public function getEventMessages(Request $request,$event_type,$load_type){
        $messaging =  $this->messaging_service->getUserMessages(Auth::id(),$event_type);
        if ($request->ajax()){
            $data['messages'] = $messaging;
            $data['load_type'] = $load_type;
            return view('modules.messaging.admin.messaging_list_view',$data);
        }
    }

    public function getAllMessageList(Request $request){
        $data['messages'] =  $this->messaging_service->getUserMessages(Auth::id(),$request->event_type,NULL,$request->search_key);
        $my_chat_list = $this->messaging_service->getChatList(Auth::id(),$request->event_type);
        $data['more_people'] =  User::where('id','<>',Auth::id())->where('name','like','%'.$request->search_key.'%')->whereNotIn('id',$my_chat_list)->get();
        return view('modules.messaging.admin.messaging_list_view',$data);
    }

    public function showMessageDetails(Request $request){
        if (isset($request->message_id)){
            $message = $this->messaging_service->getMessageById($request->message_id);
            if (isset($message)){
                $data['message'] = $message;
                $message_details_array = $this->messaging_service->getMessageDetails($request->message_id)->toArray();
                $details = $this->messaging_service->prepareMessageDetailsData($message_details_array, $message->event_id);
                $data['message_details'] = $details['message_details'];
                $data['count'] = $details['count'];
                $data['my_id'] = Auth::user()->id;
                return view('modules.messaging.admin.message_details',$data);
            }
        }elseif (isset($request->user_id)){
            $user = User::where('id',$request->user_id)->first();
            $data['user'] = $user;
            $data['my_id'] = Auth::user()->id;
            return view('modules.messaging.admin.message_details',$data);
        }

    }

    public function loadMessagesByScroll(Request $request){
        return $this->messaging_service->getAllMessagesFromStorage($request->event_id, $request->page);
    }

    public function sendMessage(Request $request){
        return $this->messaging_service->sendMessage($request->all());
    }


}
