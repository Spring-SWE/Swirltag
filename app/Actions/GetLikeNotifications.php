<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Status;

class GetLikeNotifications
{
    public function handle()
    {
        $user = Auth::user();
        $notifications = $user->notifications;

        // Extract user IDs and status IDs from notifications
        $userIds = $notifications->pluck('data.liked_by')->unique();
        $statusIds = $notifications->pluck('data.status_id')->unique();

        // Eager load users and statuses
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');
        $statuses = Status::whereIn('id', $statusIds)->get()->keyBy('id');

        // Group and transform like notifications
        $groupedLikes = $notifications->filter(function ($notification) {
            return $notification->type === 'App\Notifications\LikeNotification';
        })->groupBy(function ($notification) {
            return $notification->data['status_id'] . '-' . $notification->created_at->format('Y-m-d-H');
        });

        $condensedLikes = $groupedLikes->map(function ($group) use ($users, $statuses) {
            $firstNotification = $group->first();

            $likerIds = $group->pluck('data.liked_by')->unique();
            $likerDetails = $likerIds->map(function ($id) use ($users) {
                $user = $users->get($id);
                return [
                    'name' => $user->name ?? 'Unknown User',
                    'avatar' => $user->avatar // Replace with your avatar field
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
        });

        // Handle other types of notifications
        $otherNotifications = $notifications->reject(function ($notification) {
            return $notification->type === 'App\Notifications\LikeNotification';
        })->map(function ($notification) use ($users, $statuses) {
            $user = $users->get($notification->data['liked_by']);
            $status = $statuses->get($notification->data['status_id']);

            return [
                'type' => $notification->type,
                'status_id' => $notification->data['status_id'] ?? null,
                'created_at' => $notification->created_at,
                'created_at_human' => $notification->created_at->diffForHumans(),
                'likedBy' => [
                    'name' => $user->name ?? 'Unknown User',
                    'avatar' => $user->avatar // Replace with your avatar field
                ],
                'status_body' => $status ? $status->body : null,
            ];
        });

        // Combine and sort all notifications
        return $condensedLikes->merge($otherNotifications)->sortByDesc('created_at');
    }
}
