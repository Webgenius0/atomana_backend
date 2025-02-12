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
     * create Expense
     * @param array $credentials
     * @param string $receptUrl
     * @param string $recept
     * @param int $businessId
     * @param int $expenseForId
     * @return mixed
     */
    public function createExpense(array $credentials, string $receptUrl, string $recept, int $businessId, int $expenseForId);
}
