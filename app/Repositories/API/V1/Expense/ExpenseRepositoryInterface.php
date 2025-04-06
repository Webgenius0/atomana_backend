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
    public function createExpense(array $credentials, string $receptUrl, string $recept, int $businessId, int $expenseForId);

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

    /**
     * updateUser
     * @param int $id
     * @param int $userId
     * @return bool
     */
    public function updateUser(int $id, int $userId);

    /**
     * updateCategory
     * @param int $id
     * @param int $categoryId
     * @return bool
     */
    public function updateCategory(int $id, int $categoryId);

    /**
     * updateSubCategory
     * @param int $id
     * @param int $subCategoryId
     * @return bool
     */
    public function updateSubCategory(int $id, int $subCategoryId);

    /**
     * updateDescription
     * @param int $id
     * @param string $description
     * @return bool
     */
    public function updateDescription(int $id, string $description);

    /**
     * updateAmount
     * @param int $id
     * @param float $amount
     * @return bool
     */
    public function updateAmount(int $id, float $amount);

    /**
     * paymentMethodAmount
     * @param int $id
     * @param int $paymentMethodId
     * @return bool
     */
    public function updatePaymentMethod(int $id, int $paymentMethodId);

    /**
     * updatePayee
     * @param int $id
     * @param string $payee
     * @return bool
     */
    public function updatePayee(int $id, string $payee);

    /**
     * updateReimbursable
     * @param int $id
     * @return bool
     */
    public function updateReimbursable(int $id);

    /**
     * updateListing
     * @param int $id
     * @param string $listing
     * @return bool
     */
    public function updateListing(int $id, string $listing);

    /**
     * updateNote
     * @param int $id
     * @param string $note
     * @return bool
     */
    public function updateNote(int $id, string $note);
}
