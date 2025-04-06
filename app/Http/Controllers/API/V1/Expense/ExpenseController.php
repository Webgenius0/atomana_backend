<?php

namespace App\Http\Controllers\API\V1\Expense;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Expense\CreateExpenseRequest;
use App\Http\Requests\API\V1\Expense\UpdateUserRequest;
use App\Http\Resources\API\V1\Expense\CreateExpenseResource;
use App\Http\Resources\API\V1\Expense\IndexExpenseResource;
use App\Models\Expense;
use App\Models\ExpenseFor;
use App\Services\API\V1\Expense\ExpenseService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExpenseController extends Controller
{
    protected ExpenseService $expenseService;

    /**
     * __construct
     * @param \App\Services\API\V1\Expense\ExpenseService $expenseService
     */
    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    /**
     * index of expenses
     * @param \App\Models\ExpenseFor $expenseFor
     * @return JsonResponse
     */
    public function index(ExpenseFor $expenseFor) {
        try {
            $response = $this->expenseService->getExpenses($expenseFor);
            return $this->success(200, 'Expense Created Successfully', new IndexExpenseResource($response));
        } catch (Exception $e) {
            Log::error('ExpenseController::index', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * Storing an Expnese
     * @param \App\Http\Requests\API\V1\Expense\CreateExpenseRequest $createExpenseRequest
     * @param \App\Models\ExpenseFor $expense_for
     * @return JsonResponse
     */
    public function store(CreateExpenseRequest $createExpenseRequest, ExpenseFor $expense_for): JsonResponse
    {
        try {
            $validatedData = $createExpenseRequest->validated();
            $response = $this->expenseService->storeExpense($validatedData, $expense_for);
            return $this->success(200, 'Expense Created Successfully',  new CreateExpenseResource($response));
        } catch (Exception $e) {
            Log::error('ExpenseController::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    public function updateUser(Expense $expense, UpdateUserRequest $updateUserRequest): JsonResponse
    {
        try {
            $validatedData = $updateUserRequest->validated();
            $this->expenseService->updateUser($expense->id, $validatedData['user_id']);
            return $this->success(200,'User Updated',);
        } catch (Exception $e) {
            Log::error('ExpenseController::updateUser', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
    public function updateCategory(Expense $expense)
    {
        try {
        } catch (Exception $e) {
            Log::error('ExpenseController::updateCategory', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
    public function updateSubCategory(Expense $expense)
    {
        try {
        } catch (Exception $e) {
            Log::error('ExpenseController::updateSubCategory', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
    public function updateDescription(Expense $expense)
    {
        try {
        } catch (Exception $e) {
            Log::error('ExpenseController::updateDescription', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
    public function updateAmount(Expense $expense)
    {
        try {
        } catch (Exception $e) {
            Log::error('ExpenseController::updateAmount', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
    public function updatePaymentMethodAmount(Expense $expense)
    {
        try {
        } catch (Exception $e) {
            Log::error('ExpenseController::updatePaymentMethodAmount', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
    public function updatePayee(Expense $expense)
    {
        try {
        } catch (Exception $e) {
            Log::error('ExpenseController::updatePayee', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
    public function updateReimbursable(Expense $expense)
    {
        try {
        } catch (Exception $e) {
            Log::error('ExpenseController::updateReimbursable', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
    public function updateListing(Expense $expense)
    {
        try {
        } catch (Exception $e) {
            Log::error('ExpenseController::updateListing', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
    public function updateNote(Expense $expense)
    {
        try {
        } catch (Exception $e) {
            Log::error('ExpenseController::updateNote', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
