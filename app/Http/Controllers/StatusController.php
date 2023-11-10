<?php

namespace App\Http\Controllers;

use App\Actions\GetConversation;
use App\Http\Requests\StoreStatusRequest;
use Illuminate\Http\RedirectResponse;
use App\Actions\StoreNewStatus;
use App\Actions\GetRepliesFromStatus;
use App\Models\Media;
use App\Models\Status;
use Inertia\Response;
use Inertia\Inertia;


class StatusController extends Controller
{

    /**
     * Show a Status and the assiociated commebts.
     */
    public function show(Status $status, GetConversation $conversations, GetRepliesFromStatus $replies)
    {
        return Inertia::render('Status/Show', [

            'status' => $status,

            'replies' => $replies->handle($status->id),

            'conversation' => $conversations->handle($status->id, auth()->id()),

        ]);
    }

    /**
     * Store a newly requested Status.
     */
    public function store(StoreStatusRequest $request, StoreNewStatus $StoreNewStatus): RedirectResponse
    {
        $status = $StoreNewStatus->handle($request);

        // Check if media was uploaded
        if ($request->filled('media_id')) {

            $media = Media::findOrFail($request->input('media_id'));

            $status->media()->attach($media);
        }

        // Check authorization before proceeding.
        $this->authorize('create', Status::class);

        // Flash a success message.
        session()->flash('success', "Your post was successful!");

        return back();

    }

}
