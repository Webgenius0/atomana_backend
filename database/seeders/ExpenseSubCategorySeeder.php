<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class ExpenseSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch category IDs dynamically
        $categories = DB::table('expense_categories')->pluck('id', 'slug');

        // Define subcategories for each category
        $subCategories = [
            'office' => ['Administration', 'Human Resources', 'IT Support', 'Procurement', 'Finance & Accounting'],
            'travel' => ['Business Travel', 'Leisure Travel', 'Budget Travel', 'Luxury Travel', 'Travel Insurance'],
            'marketing' => ['Digital Marketing', 'Content Marketing', 'Social Media Marketing', 'Email Marketing', 'SEO & SEM'],
            'training' => ['Corporate Training', 'Technical Training', 'Soft Skills Development', 'Leadership Training', 'Industry-Specific Training'],
        ];

        $data = [];
        foreach ($subCategories as $slug => $subCategoryNames) {
            if (!isset($categories[$slug])) {
                continue; // Skip if category does not exist
            }

            foreach ($subCategoryNames as $subCategory) {
                $data[] = [
                    'expense_category_id' => $categories[$slug], // Assign category ID
                    'slug' => Helper::generateUniqueSlug($subCategory, 'expense_sub_categories'),
                    'name' => $subCategory,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert subcategories
        DB::table('expense_sub_categories')->insert($data);
    }
}
