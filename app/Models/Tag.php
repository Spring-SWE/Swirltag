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
     * The Status the Media is morphed to.
     */
    public function statuses(): MorphToMany
    {
        return $this->morphedByMany(Status::class, 'taggable');
    }

}
