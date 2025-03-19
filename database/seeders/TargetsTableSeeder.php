<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;

class TargetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $years = range(2024, 2026);
        $months = range(1, 12);
        $targetTypes = ['current_sales', 'units_sold', 'expenses', 'net_profit'];

        foreach ($users as $user) {
            foreach ($years as $year) {
                foreach ($months as $month) {
                    foreach ($targetTypes as $type) {
                        DB::table('targets')->insert([
                            'user_id' => $user->id,
                            'month' => Carbon::create($year, $month, 1)->toDateString(),
                            'amount' => rand(1000, 10000), // Random amount
                            'for' => $type,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }
}
