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
                'slug' => 'my-expense-list',
                'name' => 'My Expense List',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'my-business-expenses',
                'name' => 'My Business Expenses',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'my-agent-earnings',
                'name' => 'My Agent Earnings',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
