<?php

namespace App\Actions\Media;

use Image;
use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class StoreNewMedia
{
    public function handle(UploadedFile $file): Media
    {
        //Lock creating new threads for 5 seconds
        $userId = auth()->id();

        $lock = Cache::lock('user-uploading:' . $userId, 5);

        if ($lock->get()) {
            $extension = $file->getClientOriginalExtension();
            $filename = $this->generateUniqueFilename($extension);
            $originalPath = 'media/originals/' . $filename;
            $thumbnailPath = 'media/thumbnails/' . $filename;
            $image = Image::make($file->getRealPath());
            $originalImageMaxWidth = 1920;
            $originalImageMaxHeight = 1080;
            $thumbnailImageMaxWidth = 600;
            $thumbnailImageMaxHeight = 800;

            if ($extension === 'gif') {

                // GIFs will be treated as Originals and Thumbnails will be created from the GIF.
                //This is until I figure out how im going to deal with this.
                Storage::disk('public')->put($originalPath, file_get_contents($file->getRealPath()));
                Storage::disk('public')->put($thumbnailPath, file_get_contents($file->getRealPath()));
            } else {

                // Check if either the width or the height of the image exceeds 1080p and resize keeping aspect ratio.
                if ($image->width() > $originalImageMaxWidth || $image->height() > $originalImageMaxHeight) {
                    $image->resize($originalImageMaxWidth, $originalImageMaxHeight, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }

                // Save the resized Original copy as a new file for the original
                Storage::disk('public')->put($originalPath, (string) $image->encode($extension, 75));

                //Now if the Image has a width of 600 or more, resize for Thumbnail version
                $thumbnailImage = $image;

                // Check if either the width or the height of the image exceeds 600x900 and resize keeping aspect ratio.
                 if ($thumbnailImage->width() > $thumbnailImageMaxWidth || $thumbnailImage->height() > $thumbnailImageMaxHeight) {
                    $thumbnailImage->resize($thumbnailImageMaxWidth, $thumbnailImageMaxHeight, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }

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
    }

    protected function generateUniqueFilename(string $extension): string
    {
        $uniqueId = (string) Str::uuid(); //generates random UUID.
        return "{$uniqueId}.{$extension}";
    }
}
