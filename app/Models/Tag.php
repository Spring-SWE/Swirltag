<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * The Thread the Media is morphed to.
     */
    public function threads(): MorphToMany
    {
        return $this->morphedByMany(Thread::class, 'taggable');
    }

    /**
     * The Thread the Media is morphed to.
     */
    public function comments(): MorphToMany
    {
        return $this->morphedByMany(Comment::class, 'taggable');
    }
}
