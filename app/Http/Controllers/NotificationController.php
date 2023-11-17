<?php

namespace App\Http\Controllers;

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

        // Fetch the notifications
        $likeNotifications = $getLikeNotifications->handle();
        $replyNotifications = $getReplyNotifications->handle();

        // Combine all types of notifications into one array
        $allNotifications = $likeNotifications->merge($replyNotifications);

        // Sort all notifications by 'created_at' in descending order
        //The data is mixed, so it's needed.
        $sortedNotifications = $allNotifications->sortByDesc(function ($notification) {
            return $notification['created_at'] ?? $notification->created_at;
        });

        // Mark unread notifications as read
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return Inertia::render('Notifications', [
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
