<?php

namespace App\Services\API\V1\Expense;

use App\Repositories\API\V1\Expense\ExpenseRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class ExpenseService extends ExpenseRepository
{
    /**
     * creating an Expense
     * @param array $credentials
     * @return mixed
     */
    public function storeExpense(array $credentials):mixed
    {
        try {
            $data = $this->createExpense($credentials);
            return $data;
        } catch (Exception $e) {
            Log::error("ExpenseService::storeExpense", ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
