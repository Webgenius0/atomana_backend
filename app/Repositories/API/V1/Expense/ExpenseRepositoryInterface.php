<?php

namespace App\Repositories\API\V1\Expense;

interface ExpenseRepositoryInterface
{
    /**
     * creating an Expense
     * @param array $credentials
     * @return mixed
     */
    public function getAllExpense(int $type, int $perPage);

    /**
     * creating an expense
     * @param array $credentials
     * @return mixed
     */
    public function createExpense(array $credentials);
}
