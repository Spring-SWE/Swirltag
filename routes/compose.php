<?php

use App\Http\Controllers\ComposeController;
use Illuminate\Support\Facades\Route;

Route::post('store-thread', [ComposeController::class, 'store']);

