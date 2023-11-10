<?php
namespace App\Actions;

use App\Models\Status;

class GetPopularStatuses {

    public function handle()
    {
        $statuses = Status::with(['user', 'media'])
        ->where('parent_id', null)
        ->orderBy('reply_count', 'desc')
        ->cursorPaginate(10);

        return $statuses;
    }
}