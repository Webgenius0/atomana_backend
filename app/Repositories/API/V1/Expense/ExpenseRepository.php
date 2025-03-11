<?php

namespace App\Repositories\API\V1\Expense;

use App\Models\Expense;
use Exception;
use Illuminate\Support\Facades\Log;

class ExpenseRepository implements ExpenseRepositoryInterface
{
    /**
     * get all expenses of the business based on type in paginated way
     * @param int $expenseForId
     * @param int $perPage
     * @param int $businessId
     * @return mixed
     */
    public function getAllExpense(int $expenseForId, int $perPage, int $businessId): mixed
    {
        try {
            $expenses = Expense::select([
                'id',
                'expense_for_id',
                'expense_category_id',
                'expense_sub_category_id',
                'description',
                'amount',
                'payment_method_id',
                'payee',
                'recept_name',
                'recept_url',
                'user_id',
                'reimbursable',
                'listing',
                'note',
                'created_at',
            ])->whereBusinessId($businessId)
                ->whereExpenseForId($expenseForId)
                ->whereArchive(false)
                ->latest()->paginate($perPage);
            return $expenses;
        } catch (Exception $e) {
            Log::error('ExpenseRepository::getAllExpense', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * create Expense
     * @param array $credentials
     * @param string $receptUrl
     * @param string $recept
     * @param int $businessId
     * @param int $expenseForId
     * @return mixed
     */
    public function createExpense(array $credentials, string $receptUrl, string $recept, int $businessId, int $expenseForId): mixed
    {
        try {
            $data = Expense::create([
                'business_id'             => $businessId,
                'user_id'                 => $credentials['user_id'],
                'expense_for_id'          => $expenseForId,
                'expense_category_id'     => $credentials['expense_category_id'],
                'expense_sub_category_id' => $credentials['expense_sub_category_id'],
                'description'             => $credentials['description'],
                'amount'                  => $credentials['amount'],
                'payment_method_id'       => $credentials['payment_method_id'],
                'payee'                   => $credentials['payee'],
                'recept_name'             => $recept,
                'recept_url'              => $receptUrl,
                'reimbursable'            => $credentials['reimbursable'],
                'listing'                 => $credentials['listing'],
                'note'                    => $credentials['note'],
            ]);
            return $data;
        } catch (Exception $e) {
            Log::error('ExpenseRepository::createExpense', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * agentsExpenseSum
     * @param mixed $userId
     * @param string $start
     * @param string $end
     */
    public function agentsExpenseSum(int $userId,  string $start, string $end)
    {
        try {
            return Expense::whereUserId($userId)
                ->whereBetween('created_at', [$start, $end])->sum('amount');
        } catch (Exception $e) {
            Log::error('ExpenseRepository::expenseSum', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * businessExpenseSum
     * @param mixed $businessId
     * @param string $start
     * @param string $end
     * @return mixed
     */
    public function businessExpenseSum(int $businessId, string $start, string $end)
    {
        try {
            return Expense::whereBusinessId($businessId)
                ->whereBetween('created_at', [$start, $end])->sum('amount');
        } catch (Exception $e) {
            Log::error('ExpenseRepository::expenseSum', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
