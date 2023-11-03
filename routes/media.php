<?php

use App\Http\Controllers\MediaController;
use Illuminate\Support\Facades\Route;

Route::post('store-media', [MediaController::class, 'store'])->name('store-media');
