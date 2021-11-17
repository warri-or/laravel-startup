<?php

namespace App\Http\Modules\Messaging;
use App\Models\Message\Messaging;

class MessagingRepository
{
    public function getLastAdminMessages($user_id){
        return Messaging::select('messaging.*','receiver.name as receiver_name',
            'sender.name as sender_name','sender.profile_photo_path as sender_image')
               ->join('users as receiver','messaging.receiver','receiver.id')
               ->join('users as sender','messaging.sender','sender.id')
               ->where('messaging.receiver',$user_id)
               ->orderBy('id','desc')
               ->first();
    }

    public function getUserMessages($user_id,$event_type,$paginate,$search_key){
        $query = Messaging::select('messaging.*','receiver.name as receiver_name','receiver.profile_photo_path as receiver_image',
            'sender.name as sender_name','sender.profile_photo_path as sender_image')
            ->join('users as receiver','messaging.receiver','receiver.id')
            ->join('users as sender','messaging.sender','sender.id')
            ->where(function ($condition) use ($user_id){
                $condition->where('messaging.receiver',$user_id)->orWhere('messaging.sender',$user_id);
                if (!empty($search_key)){
                    $condition->where('sender.name ','like','%'.$search_key.'%');
                }
            })
            ->where('messaging.event_type',$event_type)
            ->orderBy('id','desc');
        if (!empty($paginate)){
            return $query->paginate($paginate);
        }else{
            return $query->get();
        }
    }

    public function getMessageById($message_id){
        return Messaging::select('messaging.*','receiver.name as receiver_name','receiver.profile_photo_path as receiver_image',
            'sender.name as sender_name','sender.profile_photo_path as sender_image')
            ->join('users as receiver','messaging.receiver','receiver.id')
            ->join('users as sender','messaging.sender','sender.id')
            ->where('messaging.id',$message_id)
            ->first();
    }
}
