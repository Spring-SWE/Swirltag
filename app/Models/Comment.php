<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\morphToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
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
        'thread_id',
        'parent_id',
        'is_edited',
        'upvote_count',
        'downvote_count',
        'comment_count',
        'view_count',
        'repost_count',
        'share_count',
        'deboost_score',
        'is_flagged',
    ];

    /** Comment belongs to a Thread **/
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Comment belongs to a Thread **/
    public function thread(): BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * The Media related to the Thread.
     */
    public function media(): MorphToMany
    {
        return $this->morphToMany(Media::class, 'mediable');
    }
}
