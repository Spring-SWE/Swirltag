<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Media extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'media_type',
        'file_name',
        'file_path',
        'file_size',
        'width',
        'height',
        'format',
        'duration',
        'thumbnail_path',
        'alt_text',
        'status',
    ];

     /**
     * The Comment the Media is morphed to.
     */
    public function comments(): MorphToMany
    {
        return $this->morphedByMany(Comment::class, 'mediable');
    }

    /**
     * The Thread the Media is morphed to.
     */
    public function threads(): MorphToMany
    {
        return $this->morphedByMany(Thread::class, 'mediable');
    }
}
