<?php

namespace App\Http\Controllers;

use App\Actions\GetLikeNotifications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificationController extends Controller
{

    public function show()
    {
        $getLikeNotifications = new GetLikeNotifications();
        $finalNotifications = $getLikeNotifications->handle();

        //mark read after visting page
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return Inertia::render('Notifications', [
            'notifications' => $finalNotifications,
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
