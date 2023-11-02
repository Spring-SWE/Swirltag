<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    /**
     * The Thread the Media is morphed to.
     */
    public function threads()
    {
        return $this->morphedByMany(Thread::class, 'mediable');
    }
}
