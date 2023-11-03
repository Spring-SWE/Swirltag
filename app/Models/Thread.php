<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\morphToMany;

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
