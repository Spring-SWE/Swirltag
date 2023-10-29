<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreThreadRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Actions\CreateNewThread;



class ComposeThreadController extends Controller
{
    /**
     * Handle an incoming Compose request.
     */
    public function store(StoreThreadRequest $request, CreateNewThread $createNewThread): RedirectResponse
    {
        $createNewThread->handle($request);

        session()->flash('message', 'Your post was successful!');

        return back();
    }

}
