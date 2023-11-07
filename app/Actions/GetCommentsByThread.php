<?php

namespace App\Actions;

use App\Models\Comment;
use Illuminate\Support\Collection;

class GetCommentsByThread
{

    /**
     * Need to order this by user -> then desc (maybe likes?)
     */
    public function handle(int $threadId, ?int $userId): Collection
    {
        $commentsQuery = Comment::with(['user', 'media'])
            ->where('thread_id', $threadId)
            ->orderBy('created_at', 'desc')
            ->limit(10);

        if ($userId !== null) {
            $commentsQuery->orderByRaw('user_id = ? DESC', [$userId]);
        }

        $comments = $commentsQuery->get();

        return $comments;
    }







}
