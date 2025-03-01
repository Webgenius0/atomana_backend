<?php

namespace App\Repositories\API\V1\Expense\SubCatetory;

use App\Helpers\Helper;
use App\Models\ExpenseSubCategory;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class ExpenseSubCategoryRepository implements ExpenseSubCategoryRepositoryInterface
{
    /**
     * gets all the data form the expense sub category table
     * @return \Illuminate\Database\Eloquent\Collection<int, ExpenseSubCategory>
     */
    public function getExpenseSubCategories(int $categoryId): Collection
    {
        try {
            $subCategories = ExpenseSubCategory::select('id', 'name')->whereExpenseCategoryId($categoryId)->get();
            return $subCategories;
        } catch (Exception $e) {
            Log::error('ExpenseCategoryRepository::getExpenseCategories', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * storeExpenseSubCaregory
     * @param array $credential
     * @return ExpenseSubCategory
     */
    public function storeExpenseSubCaregory(array $credential): ExpenseSubCategory
    {
        try {
            return ExpenseSubCategory::create([
                'expense_category_id' => $credential['expense_category_id'],
                'name' => $credential['name'],
                'slug' => Helper::generateUniqueSlug($credential['name'], 'expense_sub_categories'),
            ]);
        } catch (Exception $e) {
            Log::error('ExpenseCategoryRepository::storeSubCaregory', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
