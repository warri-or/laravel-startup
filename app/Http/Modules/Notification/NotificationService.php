<?php

namespace App\Http\Modules\Notification;

use App\Models\Notification;
use Pusher\Pusher;
use Pusher\PusherException;
use function RingCentral\Psr7\str;

class NotificationService
{
    // Your methods for repository

    public function sendNotificationToSingleUser($notify_body,$notify_to,$channel){
        $post_data = [
            'user_id' =>$notify_to['user_id'],
            'body' => json_encode($notify_body),
            'type' => $notify_to['type']
        ];
        Notification::create($post_data);
        $channel = $channel.'_'.$notify_to['user_id'];
        $this->triggerNotification($channel,'user_notification',$notify_body['title'],$notify_body['body']);
    }

    public function sendNotificationToMultipleUser($notify_body,$notify_to,$channel){
        $post_data = [];
        if (is_array($notify_to['user_id'])){
            if (!empty($notify_to['user_id'][0])){
                foreach ($notify_to['user_id'] as $user){
                    $post_data['user_id'] = $user;
                    $post_data['body'] =  json_encode($notify_body);
                    $post_data['type'] =  $notify_to['type'];
                    Notification::create($post_data);
                    $trigger_channel = $channel.'_'.$user;
                    $this->triggerNotification($trigger_channel,'user_notification',$notify_body['title'],$notify_body['body']);
                }
            }
        }

    }

    public function sendNotificationToAllUser($notify_body,$channel){
        $this->triggerNotification($channel,'user_notification',$notify_body['title'],$notify_body['body']);
    }


    public static function triggerNotification($channel = '',$event= '', $title = '', $body = '') {
        if ($channel != '') {
            $config = config('broadcasting.connections.pusher');
            try {
                $broadcust = new Pusher($config['key'], $config['secret'], $config['app_id'], $config['options'], env('LARAVEL_WEBSOCKETS_HOST','http://localhost'), env('LARAVEL_WEBSOCKETS_PORT',6020));
                $data['title'] = $title;
                $data['body'] = $body;
                $broadcust->trigger($channel, $event, $data);
            } catch (PusherException $e) {

            }
        }
    }
}
