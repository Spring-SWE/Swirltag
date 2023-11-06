<?php

namespace App\Actions;

use App\Models\Thread;
use Illuminate\Support\Collection;

class GetLatestThreadsByUser
{

    public function handle(string $username): Collection
    {
        $threads = Thread::with('media')
            ->whereHas('user', function ($query) use ($username) {
                $query->where('name', $username);
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

            foreach ($threads as $thread) {
                $thread->created_at_human = $thread->created_at->diffForHumans();
            }

        return $threads;
    }
}
