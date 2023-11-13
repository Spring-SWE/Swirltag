<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;
use App\Models\Status;

class GetRepliesFromStatus
{

    public function handle(string $statusId)
    {
        $user = Auth::user();

        $statuses = Status::with(['user', 'media', 'likes'])
            ->where('parent_id', $statusId)
            ->orderBy('created_at', 'desc')
            ->cursorPaginate(10);

        if ($user) {
            $statuses->load(['likes' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }]);
        }

        return $statuses;
    }
}
