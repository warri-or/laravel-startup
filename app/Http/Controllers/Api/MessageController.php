<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\FrontEnd\MessageService;
use App\Http\Services\Message\MessagingService;
use App\Models\Message\Messaging;
use App\Models\Message\MessagingDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    private $message_service,$admin_message_service;
    public function __construct(MessageService $message_service,MessagingService $admin_message_service){
        $this->message_service = $message_service;
        $this->admin_message_service = $admin_message_service;
    }
    public function sendAuctionMessage(Request $request){
        $check_data = [
            'event_type' => 'auction',
            'event_id' => $request->event_id,
            'receiver' => $request->receiver,
            'sender' => Auth::user()->id,
        ];
        $check_inbox = Messaging::where($check_data)->first();
        if (isset($check_inbox)){
            $this->lastMessageInboxUpdate($check_inbox->id, $request->message);
            $message_details = [
                'messaging_id'=>$check_inbox->id,
                'sender'=> Auth::user()->id,
                'message'=> $request->message,
                'created_at' => Carbon::now()
            ];
            return $this->message_service->sendAuctionMessage($request->event_id, $message_details);
        }else{
            $chat_data = [
                'event_type'=>'auction',
                'event_id'=>$request->event_id,
                'receiver'=> $request->receiver,
                'sender'=> Auth::user()->id,
                'last_message_date'=> Carbon::now(),
                'last_message'=> $request->message
            ];
            $message = Messaging::create($chat_data);
            $message_details = [
                'messaging_id'=>$message->id,
                'sender'=> Auth::user()->id,
                'message'=> $request->message,
                'created_at' => Carbon::now()
            ];
            return $this->message_service->sendAuctionMessage($request->event_id, $message_details);
        }
    }

    private function lastMessageInboxUpdate($id,$message){
        $update_inbox = [
            'last_message' => $message,
            'last_message_date' => Carbon::now(),
            'seen' => INACTIVE
        ];
        Messaging::where('id',$id)->update($update_inbox);
    }


    public function getAuctionMessageList(Request $request){
        try {
            $data['messages'] = Messaging::select('messaging.*','users.name','users.profile_photo_path','products.name as auction_name')
                                                ->join('auctions','messaging.event_id','=','auctions.id')
                                                ->join('products','auctions.product_id','=','products.id')
                                                ->join('users','messaging.receiver','=','users.id')
                                                ->where('messaging.event_type','auction')
                                                ->where('messaging.sender',Auth::user()->id)
                                                ->paginate(10);

            $data['image_path'] = asset(get_image_path('user'));
            return jsonResponse(TRUE)->message(__('Auction message get successfully'))->data($data);
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->default();
        }

    }

    public function getAuctionMessageDetails(Request $request){
        try {
            if ($request->has('page') && $request->page != ''){
                $page = $request->page;
                return $this->admin_message_service->getAllMessagesFromStorage($request->id,$page);
            }else{
                $message = Messaging::where('id',$request->id)->first();
                $message_details = MessagingDetails::select('messaging_details.*','users.name','users.profile_photo_path')
                                                   ->join('users','messaging_details.sender','=','users.id')
                                                   ->where('messaging_details.messaging_id',$request->id)
                                                   ->get()->toArray();

                $details = $this->admin_message_service->prepareMessageDetailsData($message_details,$message->event_id);

                $data['messages'] = $details['message_details'];
                $data['next_page'] = $details['count'];
                $data['image_path'] = asset(get_image_path('user'));
                return jsonResponse(TRUE)->message(__('Message get successfully.'))->data($data);
            }
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->message($exception->getMessage());
        }

    }

    public function sendAdminMessage(Request $request){
        $check_data = [
            'event_type' => 'admin',
            'event_id' => $request->event_id,
            'receiver' => $request->event_id,
            'sender' => Auth::user()->id,
        ];
        $check_inbox = Messaging::where($check_data)->first();

        if (isset($check_inbox)){
            $this->lastMessageInboxUpdate($check_inbox->id, $request->message);
            $message_details = [
                'messaging_id'=>$check_inbox->id,
                'sender'=> Auth::user()->id,
                'message'=> $request->message,
                'created_at' => Carbon::now()
            ];
            return $this->message_service->sendAdminMessage($message_details);
        }else{
            $chat_data = [
                'event_type'=>'admin',
                'event_id'=>$request->event_id,
                'receiver'=> $request->event_id,
                'sender'=> Auth::user()->id,
            ];
            $message = Messaging::create($chat_data);
            $message_details = [
                'messaging_id'=>$message->id,
                'sender'=> Auth::user()->id,
                'message'=> $request->message,
                'created_at' => Carbon::now()
            ];
            return $this->message_service->sendAdminMessage($message_details);
        }
    }

    public function getAdminMessageList(Request $request){
        try {
            $data['messages'] = Messaging::select('messaging.*','users.name','users.profile_photo_path')
                                         ->join('users','messaging.receiver','=','users.id')
                                         ->where('messaging.event_type','admin')
                                         ->where('messaging.sender',Auth::user()->id)
                                         ->paginate(10);
            $data['image_path'] = asset(get_image_path('user'));
            return jsonResponse(TRUE)->message(__('Admin message get successfully'))->data($data);
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->default();
        }

    }

    public function getAdminMessageDetails(Request $request){
        try {
            if ($request->has('page') && $request->page != ''){
                $page = $request->page;
                return $this->admin_message_service->getAllAdminMessagesFromStorage($request->id,$page);
            }else{
                $message = Messaging::where('id',$request->id)->first();
                $message_details = MessagingDetails::select('messaging_details.*','users.name','users.profile_photo_path')
                                                   ->join('users','messaging_details.sender','=','users.id')
                                                   ->where('messaging_details.messaging_id',$request->id)
                                                   ->get()->toArray();

                $details = $this->admin_message_service->prepareAdminMessageDetailsData($message_details,$message->event_id);

                $data['messages'] = $details['message_details'];
                $data['next_page'] = $details['count'];
                $data['image_path'] = asset(get_image_path('user'));
                return jsonResponse(TRUE)->message(__('Message get successfully.'))->data($data);
            }
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->message($exception->getMessage());
        }
    }

    public function sendLiveAuctionMessage(Request $request){
        $auction_id = (int)$request->auction_id ;
        $user = Auth::user();
        $message = [
            'auction_id'=> $auction_id,
            'user_id'=> (int)$user->id,
            'user_name'=> $user->name,
            'user_image'=> getUserAvatar($user),
            'message'=> $request->message,
            'type'=> 'text',
            'created_at'=> Carbon::now()->format('d-m-Y H:i:s')
        ];
        return $this->message_service->sendLiveMessageReply($auction_id, $message);
    }
}
