<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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
     * The Thread the Media is morphed to.
     */
    public function threads(): MorphToMany
    {
        return $this->morphedByMany(Thread::class, 'mediable');
    }
}
