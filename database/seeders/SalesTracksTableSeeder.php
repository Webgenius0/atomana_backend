<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SalesTracksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $properties = DB::table('properties')->get(); // Get all properties

        foreach ($properties as $property) {
            DB::table('sales_tracks')->insert([
                'track_id' => 'TRACK-' . $property->id, // Unique Track ID
                'business_id' => $property->business_id,
                'user_id' => $property->agent,
                'property_id' => $property->id,
                'status' => $faker->randomElement(['active', 'pending', 'close', 'expired']),
                'date_under_contract' => $faker->date('Y-m-d', '-1 year'),
                'closing_date' => $faker->dateTimeBetween('2024-12-01', '2025-12-31')->format('Y-m-d'),
                'purchase_price' => number_format($faker->randomFloat(2, 100000, 1000000), 2, '.', ''),
                'buyer_seller' => $faker->name,
                'referral_fee_pct' => number_format($faker->randomFloat(2, 1, 10), 2, '.', ''),
                'commission_on_sale' => number_format($faker->randomFloat(2, 100000, 1000000), 2, '.', ''),
                'override_split' => number_format($faker->randomFloat(2, 0, 5), 2, '.', ''),
                'note' => $faker->paragraph,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
