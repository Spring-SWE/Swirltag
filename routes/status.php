<?php

use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'throttle:post_limit'])->group(function () {
    Route::post('store-status', [StatusController::class, 'store'])->name('store-status');
});

Route::get('/status/{status}', [StatusController::class, 'show'])->name('show-status');

