<?php

namespace App\Actions\Notifications;

use Illuminate\Support\Facades\Auth;

class GetFollowNotifications
{
    public function handle()
    {
        $user = Auth::user();

        $followNotifications = $user->notifications()
                          ->where('type', 'App\Notifications\FollowNotification')
                          ->orderBy('created_at', 'desc')
                          ->take(50)
                          ->get();


        return $followNotifications;
    }
}
