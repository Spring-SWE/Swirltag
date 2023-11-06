<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use Illuminate\Http\RedirectResponse;
use App\Actions\StoreNewComment;
use App\Models\Media;



class CommentController extends Controller
{
    /**
     * Store a newly requested Thread.
     */
    public function store(int $threadID, StoreCommentRequest $request, StoreNewComment $storeNewComment): RedirectResponse
    {
        $thread = $storeNewComment->handle($request);

        // Check if media was uploaded
        if ($request->filled('media_id')) {

            $media = Media::findOrFail($request->input('media_id'));

            $thread->media()->attach($media);
        }

        session()->flash('message', 'Your post was successful!');

        return back();
    }

}
