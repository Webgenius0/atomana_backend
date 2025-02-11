<?php

namespace App\Repositories\API\V1\Expense\SubCatetory;

use App\Models\ExpenseSubCategory;
use Illuminate\Database\Eloquent\Collection;

interface ExpenseSubCategoryRepositoryInterface
{
    /**
     * gets all the data form the expense sub category table
     * @return \Illuminate\Database\Eloquent\Collection<int, ExpenseSubCategory>
     */
    public function getExpenseSubCategories(int $categoryId):Collection;
}
