<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\morphToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Actions\ProcessText;


class Status extends Model
{
    use HasFactory, Notifiable;

    protected static function boot()
    {
        parent::boot();

        // When a new status is created, increment the reply count on the parent status if it exists.
        static::created(function ($status) {
            if ($status->parent_id) {
                $parent = $status->parent()->first();
                if ($parent) {
                    $parent->increment('reply_count');
                }
            }
        });

        //When a Status is retrieved, linkify the body.
        static::retrieved(function ($status) {
            $status->body = ProcessText::linkify($status->body);
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'body',
        'user_id',
        'parent_id',
        'reply_count',
        'view_count',
        'repost_count',
        'share_count',
    ];

    protected $appends = ['created_at_human'];

    /**
     * Create new human readable date on creation.
     */
    public function getCreatedAtHumanAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * The Replies related to the Status.
     */
    public function replies()
    {
        return $this->hasMany(Status::class, 'parent_id');
    }

    /**
     * The Replies related to the Status.
     */
     public function parent()
     {
         return $this->belongsTo(Status::class, 'parent_id');
     }

    /**
     * The User that owns the Status.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The Media related to the Status.
     */
    public function media(): MorphToMany
    {
        return $this->morphToMany(Media::class, 'mediable');
    }

    /**
     * The Tags related to the Status.
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * The Likes related to the Status.
     */
    public function likes()
    {
        return $this->hasMany(Like::class, 'status_id');
    }

}
