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
                'slug' => 'commission-income',
                'name' => 'Commision Income',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'cost-of-sales',
                'name' => 'Cost Of Sales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'referral-fee',
                'name' => 'Referral Fee',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'operating-expenses',
                'name' => 'Operating Expenses',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'gross-profit',
                'name' => 'Gross Profit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'net-income',
                'name' => 'Net Income',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
