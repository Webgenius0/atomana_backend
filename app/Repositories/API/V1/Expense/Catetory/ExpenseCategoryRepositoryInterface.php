<?php

namespace App\Repositories\API\V1\Expense\Catetory;

use App\Models\ExpenseCategory;
use Illuminate\Database\Eloquent\Collection;

interface ExpenseCategoryRepositoryInterface
{
    /**
     * gets all the data form the expense type table
     * @return \Illuminate\Database\Eloquent\Collection<int, ExpenseCategory>
     */
    public function getExpenseCategories():Collection;
}
