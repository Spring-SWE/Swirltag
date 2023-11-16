<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $casts = [
        'data' => 'array', // Cast the JSON data to an array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor for liked_by ID
    public function getLikedByIdAttribute()
    {
        return $this->data['liked_by'] ?? null;
    }

    // Relationship for the user who liked
    public function likedBy()
    {
        // Use the accessor to fetch the user ID from the JSON data
        return $this->belongsTo(User::class, 'id', 'liked_by_id');
    }

    // Accessor for status_id
    public function getStatusIdAttribute()
    {
        return $this->data['status_id'] ?? null;
    }

    // Relationship for the status
    public function status()
    {
        // Use the accessor to fetch the status ID from the JSON data
        return $this->belongsTo(Status::class, 'id', 'status_id');
    }


}

