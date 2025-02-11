<?php

namespace App\Services\API\V1\Expense\SubCatetory;

use App\Repositories\API\V1\Expense\SubCatetory\ExpenseSubCategoryRepositoryInterface;

class ExpenseSubCategoryService
{
    protected ExpenseSubCategoryRepositoryInterface $expenseSubCategoryRepository;

    /**
     * __construct
     * @param \App\Repositories\API\V1\Expense\SubCatetory\ExpenseSubCategoryRepositoryInterface $expenseSubCategoryRepository
     */
    public function __construct(ExpenseSubCategoryRepositoryInterface $expenseSubCategoryRepository)
    {
        $this->expenseSubCategoryRepository = $expenseSubCategoryRepository;
    }
}
