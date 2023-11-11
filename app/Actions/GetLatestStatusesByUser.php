<?php

namespace App\Actions;

use App\Models\Status;
use Illuminate\Support\Collection;

class GetLatestStatusesByUser
{

    public function handle(string $username)
    {
        $statuses = Status::with(['user', 'media'])
            ->whereHas('user', function ($query) use ($username) {
                $query->where('name', $username);
                $query->where('parent_id', null);
            })
            ->orderBy('created_at', 'desc')
            ->cursorPaginate(50);

        return $statuses;
    }
}
