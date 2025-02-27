<?php

namespace App\Services\API\V1\Expense\Catetory;

use App\Models\ExpenseCategory;
use App\Repositories\API\V1\Expense\Catetory\ExpenseCategoryRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
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
    public function getCategories(): mixed
    {
        try {
            $data = $this->expenseCategoryRepository->getExpenseCategories();
            return $data;
        } catch (Exception $e) {
            Log::error('ExpenseCategoryService::getCategories', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Summary of create
     * @param array $categories
     * @return \App\Models\ExpenseCategory
     */
    public function create(array $categories): ExpenseCategory
    {
        try {
            return $this->expenseCategoryRepository->createExpenseCategory($categories);
        } catch (Exception $e) {
            Log::error('ExpenseCategoryService::create', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    /**
     * search by name
     * @return \Illuminate\Database\Eloquent\Collection<int, ExpenseCategory>
     */
    public function search(): Collection
    {
        try {
            $name =  trim(require('name'));
            return $this->expenseCategoryRepository->searchByNameExpenseCategory($name);
        } catch (Exception $e) {
            Log::error('ExpenseCategoryService::create', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
