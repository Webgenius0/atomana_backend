<?php

namespace App\Repositories\API\V1\Expense;

interface ExpenseRepositoryInterface
{
    /**
     * get all expenses of the business based on type in paginated way
     * @param int $expenseForId
     * @param int $perPage
     * @param int $businessId
     * @return mixed
     */
    public function getAllExpense(int $expenseForId, int $perPage, int $businessId);

    /**
     * create Expense
     * @param array $credentials
     * @param string $receptUrl
     * @param string $recept
     * @param int $businessId
     * @param int $expenseForId
     * @return mixed
     */
    public function createExpense(array $credentials, int $userId, string $receptUrl, string $recept, int $businessId, int $expenseForId);

    /**
     * agentsExpenseSum
     * @param mixed $userId
     * @param string $start
     * @param string $end
     */
    public function agentsExpenseSum(int $userId,  string $start, string $end);

    /**
     * businessExpenseSum
     * @param mixed $businessId
     * @param string $start
     * @param string $end
     * @return mixed
     */
    public function businessExpenseSum(int $businessId,  string $start, string $end);
}
