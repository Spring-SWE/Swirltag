<?php

namespace App\Actions;

use App\Actions\ProcessHashtags;
use Illuminate\Http\Request;
use App\Models\Thread;
use Illuminate\Support\Facades\Cache;

class StoreNewThread
{
    public function handle(Request $request)
    {
        $userId = $request->user()->id;
        $body = $request->input('body');

        // Lock creating new threads for 5 seconds to prevent spam
        $lock = Cache::lock('user-posting:' . $userId, 5);

        if ($lock->get()) {
            // Process hashtags before creating the thread
            $processHashtags = new ProcessHashtags();
            $processHashtags($body);

            $threadData = [
                'body' => $body,
                'user_id' => $userId,
            ];

            if ($request->filled('media_id')) {
                $threadData['media_id'] = $request->input('media_id');
            }

            // Create the thread
            $thread = Thread::create($threadData);

            // Always release the lock after the operation
            $lock->release();

            return $thread;
        }
    }
}
