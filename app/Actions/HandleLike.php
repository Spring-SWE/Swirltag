<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;
use App\Models\Status;
use App\Models\Like;

class HandleLike
{
    public function handle($statusId)
    {
        // Check if the user has already liked the status
        $existingLike = Like::where('user_id', Auth::id())
            ->where('status_id', $statusId)
            ->first();

        if ($existingLike) {
            // User has already liked the status, so delete the like to "unlike" it
            $existingLike->delete();

            // Update the status to decrement the number of likes
            $status = Status::find($statusId);
            $status->like_count--;
            $status->save();

            return response()->json(['message' => 'Status unliked']);
        }

        // User has not liked the status, so create a new like to "like" it
        $like = new Like();
        $like->user_id = Auth::id();
        $like->status_id = $statusId;
        $like->save();

        // Update the status to increment the number of likes
        $status = Status::find($statusId);
        $status->like_count++;
        $status->save();

        return response()->json(['message' => 'Status liked']);
    }
}
