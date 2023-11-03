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

        /**
         * This will return the thread data to the controller
         * WITH the media_id if the User is uploading a Media.
         */
        $thread = Thread::create($threadData);

        return $thread;
    }
}
