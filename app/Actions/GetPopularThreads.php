<?php
namespace App\Actions;

use App\Models\Thread;
use Illuminate\Support\Collection;

class GetPopularThreads {

    public function handle(): Collection
    {
        $threads = Thread::with(['user', 'media'])
        ->orderBy('comment_count', 'desc')->limit(15)
        ->get();

        return $threads;
    }
}
