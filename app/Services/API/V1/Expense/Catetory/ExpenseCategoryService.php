<?php

namespace App\Services\API\V1\Expense\Catetory;

use App\Repositories\API\V1\Expense\Catetory\ExpenseCategoryRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class ExpenseCategoryService
{
    protected ExpenseCategoryRepositoryInterface $expenseCategoryRepository;

    /**
     * __construct
     * @param \App\Repositories\API\V1\Expense\Catetory\ExpenseCategoryRepositoryInterface $expenseCategoryRepository
     */
    public function __construct(ExpenseCategoryRepositoryInterface $expenseCategoryRepository)
    {
        $this->expenseCategoryRepository = $expenseCategoryRepository;
    }

    /**
     * Summary of getCategories
     * @return \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExpenseCategory>
     */
    public function getCategories():mixed
    {
        try {
            $data = $this->expenseCategoryRepository->getExpenseCategories();
            return $data;
        } catch (Exception $e) {
            Log::error('ExpenseCategoryService::getCategories', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
