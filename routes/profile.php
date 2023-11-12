<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/{name}', [ProfileController::class, 'show']);
Route::patch('/{name}', [ProfileController::class, 'update'])->name('profile-update');
