<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Status;
use Faker\Factory as FakerFactory;

class StatusSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create();

        $users = User::all();

        foreach ($users as $user) {
            $statusCount = rand(5, 100);

            for ($i = 0; $i < $statusCount; $i++) {
                Status::create([
                    'body' => $faker->text,
                    'user_id' => $user->id,
                    'reply_count' => $faker->numberBetween(0, 100),
                    'view_count' => $faker->numberBetween(0, 500),
                    'repost_count' => $faker->numberBetween(0, 50),
                    'share_count' => $faker->numberBetween(0, 50),
                    'is_archived' => $faker->boolean(50), // 50% chance of being true
                ]);
            }
        }
    }
}
