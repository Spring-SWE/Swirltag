<?php

namespace App\Actions;

use Illuminate\Http\Request;
use App\Models\Thread;
use Illuminate\Support\Facades\Cache;

class StoreNewThread
{

    public function handle(Request $request)
    {
        $userId = $request->user()->id;

        //Lock creating new threads for 5 seconds
        $lock = Cache::lock('user-posting:' . $userId, 5);

        if ($lock->get())
        {

            $threadData = [
                'body' => $request->input('body'),
                'user_id' => $userId,
            ];

            if ($request->filled('media_id')) {

                $threadData['media_id'] = $request->input('media_id');
            }

            $thread = Thread::create($threadData);

            return $thread;
        }
    }
}
