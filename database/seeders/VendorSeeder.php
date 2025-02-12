<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vendors')->insert([
            [
                'slug' => 'client-payment',
                'name' => 'Client Payment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'staging-company',
                'name' => 'Staging Company',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'referral-agent',
                'name' => 'Referral Agent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'isp-provider',
                'name' => 'IST Provider',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'association-inc',
                'name' => 'Association Inc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
