<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\PrivateChannel;

class LikeNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $like;

    public function __construct($like)
    {
        $this->like = $like;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'liked_by' => $this->like->user_id,
            'status_id' => $this->like->status_id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        \Log::info("Broadcasting like notification to user: " . $this->like->user_id);

        return new BroadcastMessage([
            'liked_by' => $this->like->user_id,
            'status_id' => $this->like->status_id,
        ]);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.' . $this->like->user_id);
    }
}
