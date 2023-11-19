<?php

namespace App\Actions\Notifications;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Status;

class GetLikeNotifications
{
    public function handle()
    {
        $user = Auth::user();
        $notifications = $user->notifications;

        // Filter out only LikeNotification
        $likeNotifications = $notifications->filter(function ($notification) {
            return $notification->type === 'App\Notifications\LikeNotification';
        })->take(50);

        // Extract user IDs and status IDs from LikeNotifications
        $userIds = $likeNotifications->pluck('data.liked_by')->unique();
        $statusIds = $likeNotifications->pluck('data.status_id')->unique();

        // Eager load users and statuses
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');
        $statuses = Status::whereIn('id', $statusIds)->get()->keyBy('id');

        // Group and transform like notifications
        $groupedLikes = $likeNotifications->groupBy(function ($notification) {
            return $notification->data['status_id'] . '-' . $notification->created_at->format('Y-m-d-H');
        });

        return $groupedLikes->map(function ($group) use ($users, $statuses) {
            $firstNotification = $group->first();

            $likerIds = $group->pluck('data.liked_by')->unique();
            $likerDetails = $likerIds->map(function ($id) use ($users) {
                return [
                    'name' => $users->get($id)->name ?? 'Unknown User',
                    'avatar' => $users->get($id)->avatar // Replace with your avatar field
                ];
            });

            return [
                'type' => $firstNotification->type,
                'status_id' => $firstNotification->data['status_id'],
                'like_count' => $group->count(),
                'likers' => $likerDetails->toArray(),
                'created_at' => $firstNotification->created_at,
                'created_at_human' => $firstNotification->created_at->diffForHumans(),
                'status_body' => $statuses->get($firstNotification->data['status_id'])->body ?? null,
            ];
        })->sortByDesc('created_at');
    }
}
