<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Follow extends Pivot
{
    public $incrementing = false;
    protected $table = 'follows';
    public $timestamps = false;

    protected static function booted()
    {
        static::created(function ($follow) {
            $follow->followedUser->increment('followers_count');
            $follow->user->increment('following_count');
        });

        static::deleted(function ($follow) {
            $follow->followedUser->decrement('followers_count');
            $follow->user->decrement('following_count');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function followedUser()
    {
        return $this->belongsTo(User::class, 'followed_user_id');
    }
}
