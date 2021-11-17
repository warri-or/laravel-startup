<?php

namespace App\Console\Commands;

use App\Http\Services\Auction\LiveAuctionService;
use Illuminate\Console\Command;

class MakeLiveAuction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction:live';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make command live';

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
       LiveAuctionService::makeAuctionLive();
       $this->info('Action made live successfully!');
    }
}
