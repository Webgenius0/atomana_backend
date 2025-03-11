<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpenseForSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert data into expense_fors table
        DB::table('expense_fors')->insert([
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
            ]
        ]);
    }
}
