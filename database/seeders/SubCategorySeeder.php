<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 1; $i <= 6; $i++)
        {
            DB::table('expense_sub_categories')->insert([
                [
                    'expense_category_id' => $i,
                    'slug' => Helper::generateUniqueSlug( 'Marketing', 'expense_sub_categories'),
                    'name' => 'Marketing',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'expense_category_id' => $i,
                    'slug' => Helper::generateUniqueSlug( 'Option 2', 'expense_sub_categories'),
                    'name' => 'Option 2',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
