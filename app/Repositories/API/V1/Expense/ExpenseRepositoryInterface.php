<?php

namespace App\Repositories\API\V1\Expense;

interface ExpenseRepositoryInterface
{
    public function getAllExpense(int $type, int $perPage);

    public function createExpense(array $credentials);
}
