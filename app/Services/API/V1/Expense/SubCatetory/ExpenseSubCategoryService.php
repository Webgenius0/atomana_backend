<?php

namespace App\Services\API\V1\Expense\SubCatetory;

use App\Repositories\API\V1\Expense\SubCatetory\ExpenseSubCategoryRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;

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

    /**
     * get all the subcagegoryes of $expenseCategory
     * @param mixed $categoryId
     * @return \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExpenseSubCategory>
     */
    public function getSubCagegories($expenseCategory):mixed
    {
        try {
            $data = $this->expenseSubCategoryRepository->getExpenseSubCategories($expenseCategory->id);
            return $data;
        } catch (Exception $e) {
            Log::error('ExpenseSubCategoryService::getSubCagegories', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
