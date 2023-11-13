<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;
use App\Models\Status;

class GetLatestStatusesByUser
{

    public function handle(string $username)
    {
        $user = Auth::user();

        $statuses = Status::with(['user', 'media', 'likes'])
            ->whereHas('user', function ($query) use ($username) {
                $query->where('name', $username);
                $query->where('parent_id', null);
            })
            ->orderBy('created_at', 'desc')
            ->cursorPaginate(50);

        if ($user) {
            $statuses->load(['likes' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }]);
        }

        return $statuses;
    }
}
