<?php

use App\Http\Controllers\ThreadController;
use Illuminate\Support\Facades\Route;

Route::post('store-thread', [ThreadController::class, 'store'])->name('store-thread');

