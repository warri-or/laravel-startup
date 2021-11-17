<?php

namespace App\Jobs;

use App\Http\Services\MailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $template,$email,$body,$subject;

    public function __construct($template,$email,$body,$subject)
    {
        $this->template = $template;
        $this->email = $email;
        $this->body = $body;
        $this->subject = $subject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mailService = new MailService();
        $mailService->sendMailProcess($this->template,$this->body,$this->email,$this->subject);
    }
}
