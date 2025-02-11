<?php

namespace App\Repositories\API\V1\Expense;

use App\Models\Expense;
use Exception;
use Illuminate\Support\Facades\Log;

class ExpenseRepository implements ExpenseRepositoryInterface
{
    /**
     * getting all expenses of a perticuler type
     * @param int $type
     * @param int $perPage
     */
    public function getAllExpense(int $type, int $perPage = 25):mixed
    {
        try {
            $expenses = Expense::whereExpenseTypeId($type)->latest()->paginate($perPage);
            return $expenses;
        }catch (Exception $e) {
            Log::error('ExpenseRepository::getAllExpense', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function createExpense(array $credentials)
    {
        try {

        }catch (Exception $e) {
            Log::error('ExpenseRepository::createExpense', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
