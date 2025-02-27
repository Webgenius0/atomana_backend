<?php

namespace App\Repositories\API\V1\Expense\Catetory;

use App\Helpers\Helper;
use App\Models\ExpenseCategory;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class ExpenseCategoryRepository implements ExpenseCategoryRepositoryInterface
{
    /**
     * gets all the data form the expense category table
     * @return \Illuminate\Database\Eloquent\Collection<int, ExpenseCategory>
     */
    public function getExpenseCategories(): Collection
    {
        try {
            $categories = ExpenseCategory::select('id', 'name', 'slug')->get();
            return $categories;
        } catch (Exception $e) {
            Log::error('ExpenseCategoryRepository::getExpenseCategories', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * createExpenseCategory
     * @param array $categories
     * @return ExpenseCategory
     */
    public function createExpenseCategory(array $categories): ExpenseCategory
    {
        try {
            return ExpenseCategory::create([
                'name' => strtolower($categories['name']),
                'slug' => Helper::generateUniqueSlug($categories['name'], 'expense_categories'),
            ]);
        } catch (Exception $e) {
            Log::error('ExpenseCategoryRepository::createExpenseCategory', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    /**
     * searchByNameExpenseCategory
     * @param string $name
     * @return Collection<int, ExpenseCategory>
     */
    public function searchByNameExpenseCategory(string $name): Collection
    {
        try {
            return ExpenseCategory::where('name', 'like', '%' . $name . '%')->get();
        } catch (Exception $e) {
            Log::error('ExpenseCategoryRepository::searchByNameExpenseCategory', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
