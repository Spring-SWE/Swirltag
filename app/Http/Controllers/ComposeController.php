<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\StoreThreadRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Models\Thread;

class ComposeController extends Controller
{
    /**
     * Handle an incoming Compose request.
     */
    public function store(StoreThreadRequest $request): RedirectResponse
    {
        $thread = Thread::create([
            'body' => $request->input('body'),
            'user_id' => $request->user()->id,
        ]);

        return back();
    }

}
