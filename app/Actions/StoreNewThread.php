<?php
namespace App\Actions;

use Illuminate\Http\Request;
use App\Models\Thread;

class StoreNewThread {

    public function handle(Request $request)
    {
        $threadData = [
            'body' => $request->input('body'),
            'user_id' => $request->user()->id,
        ];

        if ($request->filled('media_id')) {

            $threadData['media_id'] = $request->input('media_id');

        }

        $thread = Thread::create($threadData);

        return $thread;
    }
}
