<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UpdateOfflineUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
protected $signature = 'users:update-offline';

    /**
     * The console command description.
     *
     * @var string
     */
  protected $description = 'Update the online status of users';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }



public function handle()
{
    $offlineThreshold = now()->subMinutes(15); // Define your threshold

    User::where('is_online', true)
        ->where('updated_at', '<', $offlineThreshold)
        ->update(['is_online' => false]);
}

}
