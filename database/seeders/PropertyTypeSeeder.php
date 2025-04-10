<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('property_types')->insert([
            [
                'slug' => 'apartment',
                'name' => 'Apartment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'land',
                'name' => 'Land',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'house',
                'name' => 'House',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
