<?php

namespace App\Actions;

use App\Models\Status;
use Illuminate\Support\Collection;

class GetConversation
{
    /**
     * Fetch the conversation chain for a given status.
     *
     * @param int $statusId The ID of the status to start the chain from.
     * @param int|null $userId The ID of the user, used for ordering if provided.
     * @return Collection The conversation chain.
     */
    public function handle(int $statusId, ?int $userId): Collection
    {
        // Initialize an empty collection to hold the conversation chain.
        $conversation = new Collection();

        // Starting with the current status, walk up the chain to the top-most parent.
        $currentStatus = Status::with(['user', 'media', 'likes'])->find($statusId);

        while ($currentStatus) {
            // Prepend the current status to the start of the conversation collection.
            $conversation->prepend($currentStatus);

            // If the current status is the top parent, break the loop.
            if (!$currentStatus->parent_id) {
                break;
            }

            // Move up the chain to the parent of the current status.
            $currentStatus = $currentStatus->parent()->with(['user', 'media', 'likes'])->first();
        }

        // Now $conversation contains the entire chain from the top parent to the status.
        return $conversation;
    }
}

