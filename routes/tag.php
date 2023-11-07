<?php
use App\Http\Controllers\TagController;

Route::get('/tags', [TagController::class, 'fetch'])->name('tags.fetch');


