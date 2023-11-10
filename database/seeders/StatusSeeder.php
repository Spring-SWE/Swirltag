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
            $statusCount = rand(30, 200);

            for ($i = 0; $i < $statusCount; $i++) {
                Status::create([
                    'body' => $faker->text,
                    'user_id' => $user->id,
                    'reply_count' => 0,
                    'view_count' => $faker->numberBetween(0, 500),
                    'repost_count' => $faker->numberBetween(0, 50),
                    'share_count' => $faker->numberBetween(0, 50),
                    'is_archived' => 0, // 50% chance of being true
                ]);

                // Introduce a 100-millisecond (0.1 second) delay between each status creation
                usleep(100000); // 100,000 microseconds = 100 milliseconds
            }
        }
    }
}
