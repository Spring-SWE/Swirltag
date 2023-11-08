<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {

            $statusCount = rand(5, 15);

            for ($i = 0; $i < $statusCount; $i++) {

                Status::create([

                    'body' => 'Sample Status body ',

                    'user_id' => $user->id,

                    'reply_count' => rand(0, 100),

                    'view_count' => rand(0, 500),

                    'repost_count' => rand(0, 50),

                    'share_count' => rand(0, 50),

                    'is_archived' => rand(0, 1) == 1,

                ]);
            }
        }
    }
}
