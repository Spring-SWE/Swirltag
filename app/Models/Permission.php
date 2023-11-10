<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function hasPermission(string $permissionName): bool
    {
        // Check if the user has the specified permission.
        return $this->roles->flatMap(function ($role) {
            return $role->permissions;
        })->pluck('name')->contains($permissionName);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
