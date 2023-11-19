<?php

namespace App\Http\Controllers;

use App\Actions\Notifications\GetFollowNotifications;
use App\Actions\Notifications\GetReplyNotifications;
use App\Actions\Notifications\GetLikeNotifications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function show()
    {
        // Instantiate the actions
        $getLikeNotifications = new GetLikeNotifications();
        $getReplyNotifications = new GetReplyNotifications();
        $getFollowNotifications = new GetFollowNotifications();

        // Fetch the notifications
        $likeNotifications = $getLikeNotifications->handle();
        $replyNotifications = $getReplyNotifications->handle();
        $followNotifications = $getFollowNotifications->handle();

        // Combine all types of notifications into one collection
        $allNotifications = $likeNotifications
                             ->merge($replyNotifications)
                             ->merge($followNotifications);

        // Sort all notifications by 'created_at' in descending order
        $sortedNotifications = $allNotifications->sortByDesc(function ($notification) {
            return $notification['created_at'] ?? $notification->created_at;
        });

        // Mark unread notifications as read
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return Inertia::render('Notifications/Notifications', [
            'notifications' => $sortedNotifications->values()->all(),
        ]);
    }

    public function getUnreadNotifications(Request $request)
    {
        $user = Auth::user();
        $unreadNotificationsCount = $user->unreadNotifications->count();

        return response()->json([
            'unreadCount' => $unreadNotificationsCount
        ]);
    }
}
