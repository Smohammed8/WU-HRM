<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class UpdateOnlineStatusOnLogout
{
    public function __construct()
    {
        //
    }

    public function handle(Logout $event)
    {
        if (Auth::check() || backpack_auth()->check()) {
            backpack_user()->update(['is_online' => false]);
        }

    }
}