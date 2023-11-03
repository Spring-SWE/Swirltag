<?php
namespace App\Actions;

use App\Models\Thread;
use Illuminate\Support\Collection;

class GetLatestThreadsByUser {

    public function handle(string $username): Collection
    {
        $threads = Thread::whereHas('user', function ($query) use ($username) {

            $query->where('name', $username);

        })
        ->orderBy('created_at', 'desc')
        ->get();

        return $threads;
    }
}
