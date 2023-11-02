<?php
namespace App\Actions;

use App\Models\Thread;
use Illuminate\Support\Collection;

class GetPopularThreads {

    public function handle(): ?Collection
    {
        $threads = Thread::with('user')->orderBy('view_count', 'desc')->get();

        return $threads;
    }
}
