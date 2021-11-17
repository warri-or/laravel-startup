<?php

namespace App\Console\Commands;
use App\Http\Services\Message\MessagingService;
use Illuminate\Console\Command;

class ProcessMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Message processing';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        MessagingService::processAuctionMessage();
        MessagingService::processAdminMessage();
    }
}
