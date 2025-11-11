<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserLike;
use App\Models\UserPicture;

class PopularUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $target = User::factory()->create([
            'name' => 'Popular Person',
            'email' => fake()->unique()->safeEmail(),
        ]);

        UserPicture::factory()->create([
            'user_id' => $target->id,
            'url' => 'https://example.com/pic.jpg',
            'is_primary' => true,
        ]);

        $likers = User::factory()->count(60)->create();

        foreach ($likers as $liker) {
            UserLike::create([
                'liker_id' => $liker->id,
                'liked_id' => $target->id,
                'is_liked' => true,
            ]);
        }
    }
}
