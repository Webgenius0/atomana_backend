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
            ['from' => 0, 'to' => 260000, 'cut' => 70, 'deduct' => 30],
            ['from' => 260001, 'to' => 520000, 'cut' => 75, 'deduct' => 25],
            ['from' => 520001, 'to' => 1040000, 'cut' => 80, 'deduct' => 20],
            ['from' => 1040001, 'to' => null, 'cut' => 90, 'deduct' => 10],
        ];

        $businesses = Business::all();

        foreach ($businesses as $business) {
            foreach ($tiers as $tier) {
                Tier::create([
                    'business_id' => $business->id,
                    'from' => $tier['from'],
                    'to' => $tier['to'],
                    'cut' => $tier['cut'],
                    'deduct' => $tier['deduct'],
                ]);
            }
        }
    }
}
