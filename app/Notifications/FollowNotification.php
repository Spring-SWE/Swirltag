<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\PrivateChannel;

class FollowNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $follower;
    protected $userToNotify;

    public function __construct(User $follower, User $userToNotify)
    {
        $this->follower = $follower;
        $this->userToNotify = $userToNotify;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'follower_id' => $this->follower->id,
            'follower_name' => $this->follower->name,
            'follower_avatar' => $this->follower->avatar,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'follower_id' => $this->follower->id,
            'follower_name' => $this->follower->name,
        ]);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.' . $this->userToNotify->id);
    }
}
