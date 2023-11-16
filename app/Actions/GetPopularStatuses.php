<?php
namespace App\Actions;

use Illuminate\Support\Facades\Auth;
use App\Models\Status;

class GetPopularStatuses {

    public function handle()
    {
        $user = Auth::user();

        $statuses = Status::with(['user', 'media', 'likes'])
        ->where('parent_id', null)
        ->orderBy('reply_count', 'desc')
        ->orderBy('created_at', 'desc')
        ->orderBy('id', 'desc')
        ->cursorPaginate(10);

        // Conditionally load the user's likes for the retrieved statuses if a user is authenticated
        if ($user) {
            $statuses->load(['likes' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }]);
        }

        return $statuses;
    }
}
