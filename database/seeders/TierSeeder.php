<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Tier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $tiers = [
            ['from' => 0, 'to' => 260000, 'cut' => 70, 'diduct' => 30],
            ['from' => 260001, 'to' => 520000, 'cut' => 75, 'diduct' => 25],
            ['from' => 520001, 'to' => 1040000, 'cut' => 80, 'diduct' => 20],
            ['from' => 1040001, 'to' => null, 'cut' => 90, 'diduct' => 10],
        ];

        $businesses = Business::all();

        foreach ($businesses as $business) {
            foreach ($tiers as $tier) {
                Tier::create([
                    'business_id' => $business->id,
                    'from' => $tier['from'],
                    'to' => $tier['to'],
                    'cut' => $tier['cut'],
                    'diduct' => $tier['diduct'],
                ]);
            }
        }
    }
}
