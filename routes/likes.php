<?php
use App\Http\Controllers\LikeController;

Route::middleware(['auth', 'throttle:like_limit'])->group(function () {
    Route::post('/like', [LikeController::class, 'like'])->name('like-status');
    Route::post('/dislike', [LikeController::class, 'dislike'])->name('dislike-status');
});



