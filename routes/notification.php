<?php

use App\Http\Controllers\NotificationController;
Route::middleware(['auth', 'throttle:like_limit'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'show'])->name('notifications');
    Route::get('/getunreadnotifications', [NotificationController::class, 'getUnreadNotifications'])->name('getunreadnotifications');
});


