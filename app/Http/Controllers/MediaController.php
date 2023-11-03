<?php

namespace App\Http\Controllers;

use App\Http\Requests\Media\StoreMediaRequest;
use App\Actions\Media\StoreNewMedia;

class MediaController extends Controller
{
    /**
     * Store a newly uploaded image.
     */
    public function store(StoreMediaRequest $request, StoreNewMedia $storeNewMedia)
    {
        $image = $request->file('image');

        $media = $storeNewMedia->handle($image);

        // Intervention Image to resize/manipulate the image..coming soon(tm)

        // Return the media info as JSON
        return response()->json([
            'id' => $media->id,
            'path' => $media->url,
        ]);
    }
}
