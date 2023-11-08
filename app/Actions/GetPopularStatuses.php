<?php
namespace App\Actions;

use App\Models\Status;
use Illuminate\Support\Collection;

class GetPopularStatuses {

    public function handle(): Collection
    {
        $statuses = Status::with(['user', 'media'])
        ->where('parent_id', null)
        ->orderBy('reply_count', 'desc')->limit(50)
        ->get();

        return $statuses;
    }
}
