<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth','throttle:post_limit'])->group(function () {
    Route::post('store-comment', [CommentController::class, 'store'])->name('store-comment');
});
