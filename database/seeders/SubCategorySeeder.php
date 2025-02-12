<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 6; $i++) {
            $randomWord1 = $faker->word;
            $randomWord2 = $faker->word;
            $randomWord3 = $faker->word;

            DB::table('expense_sub_categories')->insert([
                [
                    'expense_category_id' => $i,
                    'slug' => Helper::generateUniqueSlug($randomWord1, 'expense_sub_categories'),
                    'name' => $randomWord1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'expense_category_id' => $i,
                    'slug' => Helper::generateUniqueSlug($randomWord2, 'expense_sub_categories'),
                    'name' => $randomWord2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'expense_category_id' => $i,
                    'slug' => Helper::generateUniqueSlug($randomWord3, 'expense_sub_categories'),
                    'name' => $randomWord3, 
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
