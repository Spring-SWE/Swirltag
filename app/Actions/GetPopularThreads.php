<?php
namespace App\Actions;

use App\Models\Thread;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class GetPopularThreads {

    public function handle(): Collection
    {
        $threads = Thread::with(['user', 'media'])->orderBy('view_count', 'desc')->limit(10)->get();

        foreach ($threads as $thread) {
            $thread->created_at_human = $thread->created_at->diffForHumans();
        }

        return $threads;
    }
}
