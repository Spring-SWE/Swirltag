<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Define the permissions
        $permissions = [
            'create user',
            'edit user',
            'delete user',
            'ban user',
            'create status',
            'edit status',
            'delete status',
            'create swirl',
            'edit swirl',
            'delete swirl',
            'report',
        ];

        // Insert the permissions into the permissions table
        foreach ($permissions as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }
    }
}
