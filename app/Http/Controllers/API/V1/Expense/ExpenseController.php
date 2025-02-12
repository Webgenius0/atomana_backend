<?php

namespace App\Http\Controllers\API\V1\Expense;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Expense\CreateExpenseRequest;
use App\Models\ExpenseFor;
use App\Services\API\V1\Expense\ExpenseService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExpenseController extends Controller
{
    use ApiResponse;
    protected ExpenseService $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    public function index(ExpenseFor $expenseFor) {}

    /**
     * Storing an Expnese
     * @param \App\Http\Requests\API\V1\Expense\CreateExpenseRequest $createExpenseRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateExpenseRequest $createExpenseRequest, ExpenseFor $expense_for): JsonResponse
    {
        try {
            $validatedData = $createExpenseRequest->validated();
            $response = $this->expenseService->storeExpense($validatedData, $expense_for);
            return $this->success(200, 'Expense Created Successfully', $response);
        } catch (Exception $e) {
            Log::error('ExpenseController::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
