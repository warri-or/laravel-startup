<?php

namespace App\Http\Modules\Sog;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SogChatController extends Controller
{
    private $messaging_service;
    public function __construct(SogChatService $messaging_service){
        $this->messaging_service = $messaging_service;
    }

    public function messagingSog(){
//        $last_messagae = $this->messaging_service->getLastAdminMessage(Auth::id());
//        if (isset($last_messagae)) {
//            $data['message'] = $last_messagae;
//            $data['message_details'] = $this->messaging_service->getMessageDetails($last_messagae->message_id);
//        }
//        $data['my_id'] = Auth::user()->id;
        return view('modules.sog.sog_chat',[]);
    }

}
