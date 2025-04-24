<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PropertiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();
        $users = DB::table('users')->pluck('id'); // Get all user IDs

        foreach ($users as $userId) {
            if ($userId == 1) continue;
            for ($i = 1; $i <= 100; $i++) {
                DB::table('properties')->insert([
                    'business_id' => 1, // Change if needed
                    'agent' => $userId,
                    'sku' => 'PROP' . $userId . '-' . $i, // Unique SKU
                    'address' => $faker->address,
                    'price' => $faker->randomFloat(2, 50000, 1000000),
                    'expiration_date' => $faker->dateTimeBetween('now', '+2 years')->format('Y-m-d'),
                    'is_development' => $faker->boolean,
                    'add_to_website' => $faker->boolean,
                    'is_co_listing' => $faker->boolean,
                    'co_agent' => $faker->randomElement([null, $userId]), // Randomly set a co-agent or NULL
                    'commission_rate' => $faker->randomFloat(2, 1, 10),
                    'co_list_percentage' => $faker->randomFloat(2, 1, 10),
                    'property_source_id' => rand(1,16),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
