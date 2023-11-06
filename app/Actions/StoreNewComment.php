<?php

namespace App\Actions;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Cache;

class StoreNewComment
{

    public function handle(Request $request)
    {
        $userId = $request->user()->id;

        //Lock creating new threads for 5 seconds
        $lock = Cache::lock('user-posting:' . $userId, 5);

        if ($lock->get())
        {
            $commentData = [
                'body' => $request->input('body'),
                'user_id' => $userId,
                'thread_id' => $request->input('thread_id'),
            ];

            if ($request->filled('media_id')) {

                $commentData['media_id'] = $request->input('media_id');
            }

            $comment = Comment::create($commentData);

            return $comment;
        }
    }
}
