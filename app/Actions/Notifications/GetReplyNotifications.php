<?php

namespace App\Actions\Notifications;

use Illuminate\Support\Facades\Auth;

class GetReplyNotifications
{
    public function handle()
    {
        $user = Auth::user();

        $replyNotifications = $user->notifications()
                          ->where('type', 'App\Notifications\ReplyNotification')
                          ->orderBy('created_at', 'desc')
                          ->get();


        return $replyNotifications;
    }
}
