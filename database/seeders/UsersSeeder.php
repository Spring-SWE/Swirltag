<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Generate 20 fake user records
        \App\Models\User::factory(20)->create();
    }
}
