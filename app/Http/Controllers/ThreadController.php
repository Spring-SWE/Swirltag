<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreThreadRequest;
use Illuminate\Http\RedirectResponse;
use App\Actions\StoreNewThread;
use App\Models\Media;

class ThreadController extends Controller
{
    /**
     * Store a newly requested Thread.
     */
    public function store(StoreThreadRequest $request, StoreNewThread $storeNewThread): RedirectResponse
    {
        $thread = $storeNewThread->handle($request);

        // Check if media was uploaded
        if ($request->filled('media_id')) {

            $media = Media::findOrFail($request->input('media_id'));

            $thread->media()->attach($media);
        }

        session()->flash('message', 'Your post was successful!');

        return back();
    }

}
