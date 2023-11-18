<?php

use App\Http\Controllers\FollowsController;
Route::middleware(['auth', 'throttle:follow_limit'])->group(function () {
    Route::post('/follow/{userid}', [FollowsController::class, 'follow'])->name('follow');
    Route::post('/unfollow/{userid}', [FollowsController::class, 'unfollow'])->name('unfollow');
    Route::get('/check-follow-status/{userId}', [FollowsController::class, 'checkFollowStatus']);
});


