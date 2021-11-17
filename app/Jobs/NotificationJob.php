<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Pusher\Pusher;
use Pusher\PusherException;

class NotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $channel,$event,$title,$body;
    public function __construct($channel,$event,$title,$body)
    {
        $this->channel = $channel;
        $this->event = $event;
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->triggerNotification($this->channel,$this->event,$this->title,$this->body);
    }

    public function triggerNotification($channel = '',$event= '', $title = '', $body = '') {
        if ($channel != '') {
            $config = config('broadcasting.connections.pusher');
            try {
                $broadcust = new Pusher($config['key'], $config['secret'], $config['app_id'], $config['options'],'http://localhost', env('LARAVEL_WEBSOCKETS_PORT',6020));
                $data['title'] = $title;
                $data['body'] = $body;
                $broadcust->trigger($channel, $event, $data);
            } catch (PusherException $e) {

            }
        }
    }
}
