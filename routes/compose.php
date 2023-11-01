<?php

use App\Http\Controllers\Thread\ComposeThreadController;
use Illuminate\Support\Facades\Route;

Route::post('store-thread', [ComposeThreadController::class, 'store'])->name('store-thread');;

