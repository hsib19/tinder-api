<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $cities = [
            ['city' => 'Jakarta', 'country' => 'Indonesia', 'lat' => -6.2088, 'lng' => 106.8456],
            ['city' => 'Bandung', 'country' => 'Indonesia', 'lat' => -6.9175, 'lng' => 107.6191],
            ['city' => 'Surabaya', 'country' => 'Indonesia', 'lat' => -7.2575, 'lng' => 112.7521],
            ['city' => 'Yogyakarta', 'country' => 'Indonesia', 'lat' => -7.7956, 'lng' => 110.3695],
        ];

        for ($i = 0; $i < 10; $i++) {
            $location = $cities[array_rand($cities)];

            DB::table('users')->insert([
                'name'       => $faker->name,
                'age'        => rand(18, 60),
                'email'      => $faker->unique()->safeEmail,
                'password'   => Hash::make('password'),
                'city'       => $faker->city,
                'country'    => $faker->country,
                'latitude'   => $faker->latitude,
                'longitude'  => $faker->longitude,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
