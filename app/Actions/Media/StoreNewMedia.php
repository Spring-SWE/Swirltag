<?php

namespace App\Actions\Media;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoreNewMedia
{
    /**
     * Handle the media upload and creation process.
     */
    public function handle(UploadedFile $file): Media
    {
        $filename = $this->generateUniqueFilename($file);

        // Store the file in the public disk
        $path = $file->storeAs('media', $filename, 'public');

        // Create a new media record in the database
        $media = new Media([
            'user_id' => auth()->id(),
            'media_type' => $file->getClientOriginalExtension(),
            'file_name' => $filename,
            'file_path' => Storage::disk('public')->url($path),
            'file_size' => $file->getSize(),
            'width' => '500', // Placeholder
            'height' => '500', // Placeholder
            'format' => $file->getClientOriginalExtension(),
        ]);

        $media->save();

        $media->url = Storage::disk('public')->url($path);

        return $media;
    }

    /**
     * Generate a unique filename for the uploaded file.
     */
    protected function generateUniqueFilename(UploadedFile $file): string
    {
        // Generate a unique ID to prepend to the original filename
        $uniqueId = (string) Str::uuid();

        $extension = $file->getClientOriginalExtension();

        return "{$uniqueId}.{$extension}";
    }
}
