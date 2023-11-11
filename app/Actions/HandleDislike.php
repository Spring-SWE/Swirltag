<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;
use App\Models\Status;
use App\Models\Like;

class HandleDislike
{
    public function handle($statusId)
    {
        // Check if the user has already liked, disliked, or left it neutral
        $existingLike = Like::where('user_id', Auth::id())
            ->where('status_id', $statusId)
            ->first();

        // Find the status
        $status = Status::find($statusId);

        if ($existingLike) {
            // User has already interacted with the status
            if ($existingLike->value === -1) {
                // User disliked the status, so toggle to neutral
                $existingLike->value = 0; // Set it as neutral
                $status->like_count++; // Increment like_count
                $message = 'Status undisliked';
            } elseif ($existingLike->value === 1) {
                // User liked the status, so toggle to dislike
                $existingLike->value = -1; // Set it as dislike
                $status->like_count -= 2; // Decrement like_count by 2 (1 for dislike, 1 for undoing like)
                $message = 'Status disliked';
            } else {
                // User left the status as neutral, so toggle to dislike
                $existingLike->value = -1; // Set it as dislike
                $status->like_count--; // Decrement like_count
                $message = 'Status disliked';
            }

            $existingLike->save();
        } else {
            // User has not interacted with the status, so create a new like to "dislike" it
            $like = new Like();
            $like->user_id = Auth::id();
            $like->status_id = $statusId;
            $like->value = -1; // Set it as dislike
            $like->save();

            // Update the status to decrement the number of likes
            $status->like_count--;
            $message = 'Status disliked';
        }

        $status->save();

        return response()->json(['message' => $message]);
    }
}
