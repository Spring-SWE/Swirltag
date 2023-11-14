<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notifiable;

class LikeNotification extends Notification
{
    use Queueable, Notifiable;

    protected $like;

    /**
     * Create a new notification instance.
     */
    public function __construct($like) // Pass the like information
    {
        $this->like = $like;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification for database storage.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'liked_by' => $this->like->user_id, // Example data
            'status_id' => $this->like->status_id,
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'liked_by' => $this->like->user_id, // Example data
            'status_id' => $this->like->status_id,
        ]);
    }
}
