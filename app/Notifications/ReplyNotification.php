<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\PrivateChannel;

class ReplyNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $parent;
    protected $reply;
    protected $userId;

    public function __construct($reply, $parent, $userId)
    {
        $this->reply = $reply;
        $this->parent = $parent;
        $this->userId = $userId;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'reply_by' => $this->userId,
            'reply_to' => $this->parent->user_id,
            'parent_id' => $this->parent->id, //Named Status_id to stay uniformed.
            'reply_body' => $this->reply->body,
            'replier_avatar' => $this->reply->user->avatar,
            'replier_name' => $this->reply->user->name,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'reply_by' => $this->userId,
            'reply_to' => $this->parent->user_id,
            'parent_id' => $this->parent->id,
        ]);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.' . $this->parent->user_id); //Broadcast to the user who created the Status.
    }
}
