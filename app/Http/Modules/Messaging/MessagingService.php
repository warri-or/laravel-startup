<?php

namespace App\Http\Modules\Messaging;
use App\Http\Modules\Notification\NotificationService;
use App\Models\Message\Messaging;
use App\Models\Message\MessagingDetails;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MessagingService
{
    /**
     * Instantiate repository
     * @param Message/MessagingRepository $repository
     */
    public function __construct(MessagingRepository $repository)
    {
        $this->repo = $repository;
    }

    public function getUserMessages($user_id,$event_id,$pagination = 10,$search_key=''){
        return $this->repo->getUserMessages($user_id,$event_id,$pagination,$search_key);
    }

    public function getChatList($user_id,$event_type){
        $chat_lists = Messaging::where(function ($query) use ($user_id){
            $query->where('receiver',$user_id)->orWhere('sender',$user_id);
        })->where('event_type',$event_type)->get();

        $my_chats = [];
        foreach ($chat_lists as $chat){
            if ($chat->sender == Auth::id()){
                array_push($my_chats,$chat->receiver);
            }elseif ($chat->receiver == Auth::id()){
                array_push($my_chats,$chat->sender);
            }
        }
        return $my_chats;
    }

    public function getLastAdminMessage($user_id){
        return $this->repo->getLastAdminMessages($user_id);
    }
    public function getMessageById($id){
        return $this->repo->getMessageById($id);
    }

    public function getMessageDetails($message_id){
        return MessagingDetails::select('messaging_details.*','users.name as sender_name','users.profile_photo_path as sender_image')
                        ->join('users','messaging_details.sender','users.id')
                        ->where('messaging_id',$message_id)->get();
    }

    public function prepareMessageDetailsData($message_details_array,$auction_id,$count=0){
        $flag = 1;
        while ($flag){
            $total_count = count($message_details_array);
            if ($total_count < 10){
                $old_message = $this->getMessageFromStorage($auction_id, $count);
                if (count($old_message) == 0){
                    $flag = 0;
                    break;
                }else{
                    $message_details_array = array_merge($old_message,$message_details_array);
                }
            }else{
                $flag = 0;
                break;
            }
            $count ++ ;
        }

        $data['message_details'] = $message_details_array;
        $data['count'] = $count;
        return $data;
    }

    public function prepareAdminMessageDetailsData($message_details_array,$auction_id,$count=0){
        $flag = 1;
        while ($flag){
            $total_count = count($message_details_array);
            if ($total_count < 10){
                $old_message = $this->getAdminMessageFromStorage($auction_id, $count);
                if (count($old_message) == 0){
                    $flag = 0;
                    break;
                }else{
                    $message_details_array = array_merge($old_message,$message_details_array);
                }
            }else{
                $flag = 0;
                break;
            }
            $count ++ ;
        }

        $data['message_details'] = $message_details_array;
        $data['count'] = $count;
        return $data;
    }

    public function sendMessage(array $requestArray){
        try {
            $requestArray['created_at'] = Carbon::now();
            if (isset($requestArray['messaging_id']) && $requestArray['messaging_id'] != NULL){
                $last_message = MessagingDetails::create($requestArray);
                $this->lastMessageInboxUpdate($requestArray['messaging_id'], $requestArray['message']);
            }else{
                $new_message = $this->createNewMessaging($requestArray);
                $message_details = [
                    'messaging_id' => $new_message->id,
                    'sender' => Auth::user()->id,
                    'message' => $requestArray['message']
                ];
                $last_message = MessagingDetails::create($message_details);
            }
            $last_message->sender_name = Auth::user()->name;
            $last_message->sender_image = Auth::user()->profile_photo_path;
            $this->sendMessageNotification($last_message);
            return jsonResponse(TRUE)->message(__('Message sent successfully.'))->data([]);
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->message(__('Message sent failed.'));
        }
    }

    private function sendMessageNotification($last_message){
        $data['message_details_single'] = $last_message;
        $channel = 'user_message_'.$last_message->messaging_id;
        $event = 'user_messaging';
        $title = Auth::user()->name.__(' sent you a new message');
        NotificationService::triggerNotification($channel,$event,$title,$data);
    }

    private function createNewMessaging($requestArray){
        $insert_data = [
            'event_type' => $requestArray['event_type'],
            'event_id' => $requestArray['event_id'],
            'receiver' => $requestArray['receiver'],
            'sender' => $requestArray['sender'],
            'last_message' => $requestArray['message']
        ];
        return Messaging::create($insert_data);
    }

    private function lastMessageInboxUpdate($id,$message){
        $update_inbox = [
            'last_message' => $message,
            'last_message_date' => Carbon::now(),
            'synced'=>INACTIVE,
            'seen' => INACTIVE
        ];
        Messaging::where('id',$id)->update($update_inbox);
    }

    public function getAllMessagesFromStorage($event_id,$index){
        try {
            $data['messages'] = $this->getMessageFromStorage($event_id, $index);
            $data['count'] = $index;
            $data['image_path'] = asset(get_image_path('user'));
            return jsonResponse(TRUE)->message(__('Message get successfully.'))->data($data);
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->message($exception->getMessage());
        }
    }

    public function getMessageFromStorage($event_id,$index){
        $directory = 'user_message/message_'.$event_id;
        $files = Storage::disk('public')->listContents($directory);
        arsort($files);
        $files = array_values($files);
        if (isset($files[$index])){
            $message_array = Storage::get($files[$index]['path']);
            $message = json_decode($message_array,TRUE);
        }else{
            $message = [];
        }
        return $message;
    }

    public static function processAuctionMessage(){
        try {
            $messaging = Messaging::where(['synced'=>INACTIVE,'type'=>'auction'])->get();
            if (isset($messaging) && !empty($messaging[0])){
                foreach ($messaging as $message){
                    $message_chat = MessagingDetails::select('messaging_details.*','users.name as sender_name','users.profile_photo_path as sender_image')
                                                    ->join('users','messaging_details.sender','users.id')
                                                    ->where('messaging_details.messaging_id',$message->id)
                                                    ->get()->toArray();
                    $message_chat['auction_name'] = $message->auction_name;
                    if (isset($message_chat) && !empty($message_chat[0])){
                        $today = date("Y-m-d");
                        $directory = 'user_message/message_'.$message->event_id;
                        $path = $directory.'/'.$today;
                        Storage::disk('public')->put($path.'.json',json_encode($message_chat));
                        Messaging::where('id',$message->id)->update(['synced'=>ACTIVE]);
                        MessagingDetails::where('messaging_id',$message->id)->delete();
                    }
                }
            }
        }catch (\Exception $exception){
        }

    }

    public static function processAdminMessage(){
        try {
            $messaging = Messaging::where(['synced'=>INACTIVE,'type'=>'admin'])->get();
            if (isset($messaging) && !empty($messaging[0])){
                foreach ($messaging as $message){
                    $message_chat = MessagingDetails::select('messaging_details.*','users.name as sender_name','users.profile_photo_path as sender_image')
                                                    ->join('users','messaging_details.sender','users.id')
                                                    ->where('messaging_details.messaging_id',$message->id)->get()->toArray();
                    if (isset($message_chat) && !empty($message_chat[0])){
                        $today = date("Y-m-d");
                        $directory = 'admin_message/admin_'.$message->event_id;
                        $path = $directory.'/'.$today;
                        Storage::disk('public')->put($path.'.json',json_encode($message_chat));
                        Messaging::where('id',$message->id)->update(['synced'=>ACTIVE]);
                        MessagingDetails::where('messaging_id',$message->id)->delete();
                    }
                }
            }
        }catch (\Exception $exception){
        }
    }
}
