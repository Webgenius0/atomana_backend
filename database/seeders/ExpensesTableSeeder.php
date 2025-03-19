<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use Faker\Factory as Faker;

class ExpensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::all();

        foreach ($users as $user) {
            $expenses = [];

            for ($i = 0; $i < 100; $i++) {
                $expenses[] = [
                    'business_id' => 1,
                    'user_id' => $user->id,
                    'expense_for_id' => rand(1, 2),
                    'expense_category_id' => rand(1, 4),
                    'expense_sub_category_id' => rand(1, 5),
                    'description' => Str::random(50),
                    'amount' => round(mt_rand(1000, 100000) / 100, 2),
                    'payment_method_id' => rand(1, 3),
                    'payee' => Str::random(10),
                    'recept_name' => 'receipt_' . Str::random(5) . '.pdf',
                    'recept_url' => $faker->imageUrl(640, 480, 'business', true, 'receipt', true), // Fake image URL
                    'reimbursable' => (bool) rand(0, 1),
                    'listing' => Str::random(10),
                    'note' => Str::random(30),
                    'status' => true,
                    'archive' => false,
                    'created_at' => Carbon::create(rand(2024, 2025), rand(12, 12), rand(1, 28)),
                    'updated_at' => now(),
                ];
            }

            DB::table('expenses')->insert($expenses);
        }
    }
}
