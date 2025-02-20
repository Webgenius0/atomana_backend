<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpenseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('expense_types')->insert([
            [
                'slug' => 'income',
                'name' => 'Income',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'expense',
                'name' => 'Expense',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
