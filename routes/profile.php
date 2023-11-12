<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/{name}', [ProfileController::class, 'show'])->name('profile-show');
Route::post('/{name}', [ProfileController::class, 'update'])->name('profile-update');
