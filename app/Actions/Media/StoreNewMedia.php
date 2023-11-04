<?php

namespace App\Actions\Media;

use Image;
use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoreNewMedia
{
    public function handle(UploadedFile $file): Media
    {
        $extension = $file->getClientOriginalExtension();
        $filename = $this->generateUniqueFilename($extension);
        $originalPath = 'media/originals/' . $filename;
        $thumbnailPath = 'media/thumbnails/' . $filename;

        // Store the original file
        $file->storeAs('media/originals', $filename, 'public');

        if ($extension === 'gif') {

            //Untreat GIFs for now. Will Consider a path to resizing in the future.
            Storage::disk('public')->copy($originalPath, $thumbnailPath);
        } else {
            // Handle non-GIF files with Intervention Image
            $image = Image::make($file->getRealPath())->orientate()->resize(1920, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Save the resized image as a new file for the original
            Storage::disk('public')->put($originalPath, (string) $image->encode($extension, 75));

            // Resize for thumbnail and save
            $thumbnailImage = $image->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode($extension, 75);

            // Save the thumbnail
            Storage::disk('public')->put($thumbnailPath, (string) $thumbnailImage);
        }

        // Get URLs for both images
        $originalUrl = Storage::disk('public')->url($originalPath);
        $thumbnailUrl = Storage::disk('public')->url($thumbnailPath);

        // Create a new media record in the database
        $media = new Media([
            'user_id' => auth()->id(),
            'media_type' => $file->getClientMimeType(),
            'file_name' => $filename,
            'file_path' => $originalUrl,
            'thumbnail_path' => $thumbnailUrl,
            'file_size' => $file->getSize(),
            'width' => $extension !== 'gif' ? $image->width() : null,
            'height' => $extension !== 'gif' ? $image->height() : null,
            'format' => $extension,
        ]);

        $media->save();

        // Assign the public URLs for easy access
        $media->url = $originalUrl;
        $media->thumbnail_url = $thumbnailUrl;

        return $media;
    }

    protected function generateUniqueFilename(string $extension): string
    {
        $uniqueId = (string) Str::uuid();
        return "{$uniqueId}.{$extension}";
    }
}
