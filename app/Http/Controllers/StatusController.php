<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatusRequest;
use App\Http\Resources\StatusResource;
use Illuminate\Http\RedirectResponse;
use App\Actions\GetRepliesFromStatus;
use App\Actions\GetConversation;
use App\Actions\StoreNewStatus;
use Illuminate\Http\Request;
use App\Models\Status;
use App\Models\Media;
use Inertia\Inertia;


class StatusController extends Controller
{

    /**
     * Show a Status and the assiociated replies.
     */
    public function show(Status $status, GetConversation $conversations, GetRepliesFromStatus $replies, Request $request)
    {
        if($request->wantsJson()) {

            return StatusResource::collection($replies->handle($status->id))->response()->getData(true);

         }

        return Inertia::render('Status/Show', [

            'status' => $status,

            'replies' => StatusResource::collection($replies->handle($status->id)),

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
