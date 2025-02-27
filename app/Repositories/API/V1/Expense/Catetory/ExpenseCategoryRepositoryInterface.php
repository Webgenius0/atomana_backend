<?php

namespace App\Repositories\API\V1\Expense\Catetory;

use App\Models\ExpenseCategory;
use Illuminate\Database\Eloquent\Collection;

interface ExpenseCategoryRepositoryInterface
{
    /**
     * gets all the data form the expense category table
     * @return \Illuminate\Database\Eloquent\Collection<int, ExpenseCategory>
     */
    public function getExpenseCategories(): Collection;

    /**
     * createExpenseCategory
     * @param array $categories
     * @return ExpenseCategory
     */
    public function createExpenseCategory(array $categories): ExpenseCategory;

    /**
     * searchByNameExpenseCategory
     * @param string $name
     * @return Collection<int, ExpenseCategory>
     */
    public function searchByNameExpenseCategory(string $name): Collection;
}
