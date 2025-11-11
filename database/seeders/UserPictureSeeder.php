<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserPictureSeeder extends Seeder
{
    public function run(): void
    {
        $users = DB::table('users')->pluck('id');

        foreach ($users as $userId) {
            $totalPictures = 2; 
            $primaryIndex = rand(0, $totalPictures - 1); 

            for ($i = 0; $i < $totalPictures; $i++) {
                $gender = rand(0, 1) ? 'men' : 'women';
                $imgIndex = ($userId + $i) % 100; 

                DB::table('user_pictures')->insert([
                    'user_id' => $userId,
                    'url' => "https://randomuser.me/api/portraits/{$gender}/{$imgIndex}.jpg",
                    'is_primary' => $i === $primaryIndex,
                    'created_at' => now(),
                ]);
            }
        }
    }
}
