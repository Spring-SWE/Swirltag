<?php

namespace App\Http\Controllers;

use App\Actions\GetLikeNotifications;
use Inertia\Inertia;

class NotificationController extends Controller
{

    public function show()
    {
        $getLikeNotifications = new GetLikeNotifications();
        $finalNotifications = $getLikeNotifications->handle();

        return Inertia::render('Notifications', [
            'notifications' => $finalNotifications,
        ]);
    }
}
