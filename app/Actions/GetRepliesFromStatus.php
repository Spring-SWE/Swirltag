<?php

namespace App\Actions;

use App\Models\Status;
use Illuminate\Support\Collection;

class GetRepliesFromStatus
{

    public function handle(string $statusId)
    {
        $statuses = Status::with(['user', 'media'])
            ->where('parent_id', $statusId)
            ->orderBy('created_at', 'desc')
            ->cursorPaginate(10);

        return $statuses;
    }
}
