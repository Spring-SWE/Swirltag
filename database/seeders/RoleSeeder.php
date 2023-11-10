<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Define the roles
        $roles = [
            'guest',
            'user',
            'premium',
            'moderator',
            'administrator',
        ];

        // Insert the roles into the roles table
        foreach ($roles as $roleName) {
            Role::create(['name' => $roleName]);
        }
    }
}
