<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_methods')->insert([
            [
                'slug' => 'cash',
                'name' => 'Cash',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'credit-cart',
                'name' => 'Credit Card',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'bank-transfer',
                'name' => 'Bank Transfer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
