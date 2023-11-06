<?php

use App\Http\Controllers\ThreadController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'throttle:post_limit'])->group(function () {
    Route::post('store-thread', [ThreadController::class, 'store'])->name('store-thread');
});

Route::get('/thread/{thread}', [ThreadController::class, 'show']);

