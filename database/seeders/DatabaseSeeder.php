<?php

use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\StatusSeeder;
use Database\Seeders\UsersSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UsersSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(StatusSeeder::class);
    }
}
