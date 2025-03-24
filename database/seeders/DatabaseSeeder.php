<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // metadata
            ExpenseCategorySeeder::class,
            ExpenseForSeeder::class,
            PaymentMethodSeeder::class,
            RoleSeeder::class,
            ExpenseSubCategorySeeder::class,
            TierSeeder::class,

            // relational data
            PropertySourceSeeder::class,
            UserSeeder::class,
            ExpensesTableSeeder::class,
            TargetsTableSeeder::class,
            PropertiesTableSeeder::class,
            SalesTracksTableSeeder::class,
        ]);

    }
}
