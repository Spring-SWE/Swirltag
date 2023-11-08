<?php

namespace App\Actions;

use App\Models\Status;
use Illuminate\Support\Collection;

class GetLatestStatusesByUser
{

    public function handle(string $username): Collection
    {
        $statuses = Status::with(['user', 'media'])
            ->whereHas('user', function ($query) use ($username) {
                $query->where('name', $username);
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return $statuses;
    }
}
