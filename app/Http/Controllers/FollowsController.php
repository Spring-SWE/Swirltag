<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\FollowNotification;

class FollowsController extends Controller
{
    public function follow($userId)
    {
        // Check if the follow relationship already exists
        $alreadyFollowing = Follow::where('user_id', Auth::id())
            ->where('followed_user_id', $userId)
            ->exists();

        if (!$alreadyFollowing) {
            Follow::create([
                'user_id' => Auth::id(),
                'followed_user_id' => $userId
            ]);

            $userToNotify = User::find($userId);
            $follower = Auth::user();

            $userToNotify->notify(new FollowNotification($follower, $userToNotify));
        }

        return back();
    }

    public function unfollow($userId)
    {
        $follow = Follow::where('user_id', Auth::id())
            ->where('followed_user_id', $userId)
            ->first();

        if ($follow) {
            $follow->delete();

            // Decrement followers count logic here (if not handled by model events)
        }

        return back();
    }

    /**
     * Check if the authenticated user is following a specific user.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function checkFollowStatus($userId)
    {
        $isFollowing = Follow::where('user_id', Auth::id())
            ->where('followed_user_id', $userId)
            ->exists();

        return response()->json(['isFollowing' => $isFollowing]);
    }
}
