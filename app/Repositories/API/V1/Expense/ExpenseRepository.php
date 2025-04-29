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
            ])->with('user')->whereBusinessId($businessId)
                ->whereExpenseForId($expenseForId)
                ->whereArchive(false)
                ->orderBy('created_at', 'desc')->paginate($perPage);
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
    public function createExpense(array $credentials, $receptUrl, $recept, int $businessId, int $expenseForId): mixed
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

    /**
     * updateUser
     * @param int $id
     * @param int $userId
     * @return bool
     */
    public function updateUser(int $id, int $userId)
    {
        try {
            return Expense::findOrFail($id)->update([
                'user_id' => $userId,
            ]);
        } catch (Exception $e) {
            Log::error('ExpenseRepository::updateUser', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateCategory
     * @param int $id
     * @param int $categoryId
     * @return bool
     */
    public function updateCategory(int $id, int $categoryId)
    {
        try {
            Expense::findOrFail($id)->update([
                'expense_category_id' => $categoryId,
            ]);
            Expense::findOrFail($id)->update([
                'expense_sub_category_id' => null,
            ]);

            return true;

        } catch (Exception $e) {
            Log::error('ExpenseRepository::updateCategory', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateSubCategory
     * @param int $id
     * @param int $subCategoryId
     * @return bool
     */
    public function updateSubCategory(int $id, int $subCategoryId)
    {
        try {
            return Expense::findOrFail($id)->update([
                'expense_sub_category_id' => $subCategoryId,
            ]);
        } catch (Exception $e) {
            Log::error('ExpenseRepository::updateSubCategory', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateDescription
     * @param int $id
     * @param string $description
     * @return bool
     */
    public function updateDescription(int $id, string $description)
    {
        try {
            return Expense::findOrFail($id)->update([
                'description' => $description,
            ]);
        } catch (Exception $e) {
            Log::error('ExpenseRepository::updateDescription', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateAmount
     * @param int $id
     * @param float $amount
     * @return bool
     */
    public function updateAmount(int $id, float $amount)
    {
        try {
            return Expense::findOrFail($id)->update([
                'amount' => $amount,
            ]);
        } catch (Exception $e) {
            Log::error('ExpenseRepository::updateAmount', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * paymentMethodAmount
     * @param int $id
     * @param int $paymentMethodId
     * @return bool
     */
    public function updatePaymentMethod(int $id, int $paymentMethodId)
    {
        try {
            return Expense::findOrFail($id)->update([
                'payment_method_id' => $paymentMethodId,
            ]);
        } catch (Exception $e) {
            Log::error('ExpenseRepository::updatePaymentMethod', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updatePayee
     * @param int $id
     * @param string $payee
     * @return bool
     */
    public function updatePayee(int $id, string $payee)
    {
        try {
            return Expense::findOrFail($id)->update([
                'payee' => $payee,
            ]);
        } catch (Exception $e) {
            Log::error('ExpenseRepository::updatePayee', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateReimbursable
     * @param int $id
     * @return bool
     */
    public function updateReimbursable(int $id)
    {
        try {
            $expense = Expense::findOrFail($id);
            $expense->reimbursable = !$expense->reimbursable;
            $expense->save();
            return true;
        } catch (Exception $e) {
            Log::error('ExpenseRepository::updateReimbursable', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateListing
     * @param int $id
     * @param string $listing
     * @return bool
     */
    public function updateListing(int $id, string $listing)
    {
        try {
            return Expense::findOrFail($id)->update([
                'listing' => $listing,
            ]);
        } catch (Exception $e) {
            Log::error('ExpenseRepository::updateListing', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateNote
     * @param int $id
     * @param string $note
     * @return bool
     */
    public function updateNote(int $id, string $note)
    {
        try {
            return Expense::findOrFail($id)->update([
                'note' => $note,
            ]);
        } catch (Exception $e) {
            Log::error('ExpenseRepository::updateNote', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
