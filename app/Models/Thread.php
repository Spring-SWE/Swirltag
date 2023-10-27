<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Thread extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'post',
        'user_id',
        'votes',
        'comments',
        'reports',
        'views',
        'reposts',
        'shares'
    ];

    /**
     * Get the User that owns the Thread.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
