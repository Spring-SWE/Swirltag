<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreThreadRequest;
use Illuminate\Http\RedirectResponse;
use App\Actions\StoreNewThread;
use App\Models\Media;
use Inertia\Response;
use Inertia\Inertia;


class ThreadController extends Controller
{

    /**
     * Show a Thread and the assiociated commebts.
     */
    public function show(string $id)
    {
        return Inertia::render('Thread/Show', [
            //return page, lots of designing to do :)
        ]);
    }

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
