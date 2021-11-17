<?php


namespace App\Http\Services;


use Illuminate\Support\Facades\Log;
use Pusher\Pusher;
use Pusher\PusherException;

class BroadcastService
{
    protected $broadcast;

    public function __construct(){
        $config = config('broadcasting.connections.pusher');
        try {
            $this->broadcast = new Pusher($config['key'], $config['secret'], $config['app_id'], $config['options']);
        } catch (PusherException $e) {
            Log::info($e->getMessage());
        }
    }

    /**
     * @param string $channelName
     * @param string $eventName
     * @param $data, will be json
     * @return bool , return true when success else false
     * @throws \Pusher\PusherException
     */
    public function broadCast(string $channelName, string $eventName, $data){
        return $this->broadcast->trigger($channelName, $eventName, $data);
    }

    /**
     * @param $userId
     * @param $event
     * @param $data, will be json
     * @return array|bool , return true when success else false
     * @throws \Pusher\PusherException
     */
    public function broadcastPrivet($userId, $event, $data){
        $channelName = 'private-cd80d050631fe9cbce59cdf8678415ebe2cd39dfe6fd926099649f81d655df7.' . custom_encrypt($userId);
        return $this->broadcast->trigger($channelName, $event, $data);
    }
}
