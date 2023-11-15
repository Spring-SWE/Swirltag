<?php

use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [DashboardController::class, 'show'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::delete('/settings', [SettingsController::class, 'destroy'])->name('settings.destroy');
});

/**
 * Load routes
 */
require __DIR__ . '/auth.php';
require __DIR__ . '/notification.php';
require __DIR__ . '/status.php';
require __DIR__ . '/media.php';
require __DIR__ . '/likes.php';
require __DIR__ . '/tag.php';
require __DIR__ . '/profile.php';
