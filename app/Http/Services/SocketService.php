<?php


namespace App\Http\Services;


use App\Jobs\NotificationJob;
use Pusher\Pusher;
use Pusher\PusherException;

class SocketService
{
    public function __construct($data)
    {
        $this->data = $data;

    }

    public function receiveMessage(){
//        \Illuminate\Support\Facades\Log::info(json_encode($this->data));
        $notify_data = json_decode($this->data);
        $channel = $notify_data->channel ?? '';
        if ($channel == 'bid_notification'){
            $body = $notify_data->data ?? [];
            $title = '';
            if (!empty($body)){
                $title = $body->name ?? ''.' bid for '.$body->bid_price ?? '';
            }
            $new_channel = 'bid_receive_notification_'.$body->auction_id ?? '';

            dispatch(new NotificationJob($new_channel, 'bid_event', $title, $body));
        }
    }



}
