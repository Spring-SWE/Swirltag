<?php

use App\Http\Controllers\NotificationController;

Route::get('/notifications', [NotificationController::class, 'show'])->name('notifications');;

