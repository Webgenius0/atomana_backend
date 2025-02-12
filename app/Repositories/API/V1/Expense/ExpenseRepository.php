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

    /**
     * creating an expense
     * @param array $credentials
     * @return mixed
     */
    public function createExpense(array $credentials, string $receptUrl, string $recept, int $businessId, int $expenseForId):mixed
    {
        try {
            $data = Expense::create([
                'business_id' => $businessId,
                'expense_for_id' => $expenseForId,
                'expense_type_id' => $credentials['expense_type_id'],
                'expense_category_id' => $credentials['expense_category_id'],
                'expense_sub_category_id' => $credentials['expense_sub_category_id'],
                'description' => $credentials['description'],
                'amount' => $credentials['amount'],
                'payment_method_id' => $credentials['payment_method_id'],
                'vendor_id' => $credentials['vendor_id'],
                'recept_name' => $recept,
                'recept_url' => $receptUrl,
                'owner' => $credentials['owner'],
                'reimbursable' => $credentials['reimbursable'],
                'listing' => $credentials['listing'],
                'note' => $credentials['note'],
            ]);
            return $data;
        }catch (Exception $e) {
            Log::error('ExpenseRepository::createExpense', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
