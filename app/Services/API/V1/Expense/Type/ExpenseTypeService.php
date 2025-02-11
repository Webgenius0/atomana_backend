<?php

namespace App\Services\API\V1\Expense\Type;

use App\Repositories\API\V1\Expense\Type\ExpenseTypeRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class ExpenseTypeService
{
    protected ExpenseTypeRepositoryInterface $expenseTypeRepository;

    /**
     * __construct
     * @param \App\Repositories\API\V1\Expense\Type\ExpenseTypeRepositoryInterface $expenseTypeRepository
     */
    public function __construct(ExpenseTypeRepositoryInterface $expenseTypeRepository)
    {
        $this->expenseTypeRepository = $expenseTypeRepository;
    }


    /**
     * get data form ExpenseType Repo
     * @return \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExpenseType>
     */
    public function getTypes():mixed
    {
        try {
            $data = $this->expenseTypeRepository->getExpenseTypes();
            return $data;
        } catch (Exception $e) {
            Log::error('ExpenseTypeService::getTypes', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
