<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\morphToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'body',
        'user_id',
        'comment_count',
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
     * The Comments related to the Thread.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The User that owns the Thread.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The Media related to the Thread.
     */
    public function media(): MorphToMany
    {
        return $this->morphToMany(Media::class, 'mediable');
    }

}
