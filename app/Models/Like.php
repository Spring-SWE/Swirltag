<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    /**
     * Get the Status the Like belongs to.
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
