<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserLikeSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = DB::table('users')->pluck('id')->toArray();

        foreach ($userIds as $likerId) {
            $likedIds = collect($userIds)
                ->filter(fn($id) => $id !== $likerId)
                ->shuffle()
                ->take(rand(3, 5));

            foreach ($likedIds as $likedId) {
                DB::table('user_likes')->insert([
                    'liker_id' => $likerId,
                    'liked_id' => $likedId,
                    'is_liked' => (bool)rand(0, 1),
                    'created_at' => now(),
                ]);
            }
        }
    }
}
