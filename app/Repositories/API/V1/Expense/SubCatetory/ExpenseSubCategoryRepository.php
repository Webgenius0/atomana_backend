<?php

namespace App\Repositories\API\V1\Expense\SubCatetory;

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
    public function getExpenseSubCategories(int $categoryId):Collection
    {
        try {
            $subCategories = ExpenseSubCategory::whereExpenseCategoryId($categoryId)->get();
            return $subCategories;
        }catch (Exception $e) {
            Log::error('ExpenseCategoryRepository::getExpenseCategories', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
