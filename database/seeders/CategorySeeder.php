<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('expense_categories')->insert([
            [
                'slug' => 'office',
                'name' => 'Office',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'travel',
                'name' => 'Travel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'marketing',
                'name' => 'Marketing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'training',
                'name' => 'Training',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
