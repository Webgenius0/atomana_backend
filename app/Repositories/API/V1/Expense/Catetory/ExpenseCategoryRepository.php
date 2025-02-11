<?php

namespace App\Repositories\API\V1\Expense\Catetory;

use App\Models\ExpenseCategory;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class ExpenseCategoryRepository implements ExpenseCategoryRepositoryInterface
{
    /**
     * gets all the data form the expense type table
     * @return \Illuminate\Database\Eloquent\Collection<int, ExpenseCategory>
     */
    public function getExpenseCategories():Collection
    {
        try {
            $categories = ExpenseCategory::all();
            return $categories;
        }catch (Exception $e) {
            Log::error('ExpenseCategoryRepository::getExpenseCategories', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
