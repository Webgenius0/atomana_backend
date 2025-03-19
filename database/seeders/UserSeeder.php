<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        DB::table('users')->insert([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'handle' => 'johndoe',
            'email' => 'business@mail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'avatar' => $faker->imageUrl(400, 400, 'people', true),
            'role_id' => 2,
            'status' => true,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ]);

        DB::table('profiles')->insert([
            'user_id' => 1,
        ]);
        DB::table('businesses')->insert([
            'licence' => 15656,
            'ecar_id' => 187416,
        ]);

        DB::table('business_user')->insert([
            'user_id' => 1,
            'business_id' => 1,
        ]);


        $faker = Faker::create();

        for ($i = 1; $i <= 50; $i++) {
            $userId = DB::table('users')->insertGetId([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'handle' => $faker->userName,
                'email' => "user{$i}@mail.com",
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'avatar' => $faker->imageUrl(400, 400, 'people', true),
                'role_id' => 3,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ]);

            DB::table('business_user')->insert([
                'user_id' => $userId,
                'business_id' => 1,
            ]);

            DB::table('profiles')->insert([
                'user_id' => $userId,
                'contract_year_start' => $faker->date('Y-m-d', 'now'),
            ]);
        }
    }
}
