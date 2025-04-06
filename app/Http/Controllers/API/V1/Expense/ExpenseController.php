<?php

namespace App\Http\Controllers\API\V1\Expense;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Expense\CreateExpenseRequest;
use App\Http\Requests\API\V1\Expense\UpdateAmountRequest;
use App\Http\Requests\API\V1\Expense\UpdateCategoryRequest;
use App\Http\Requests\API\V1\Expense\UpdateDescriptionRequest;
use App\Http\Requests\API\V1\Expense\UpdateListingRequest;
use App\Http\Requests\API\V1\Expense\UpdateNoteRequest;
use App\Http\Requests\API\V1\Expense\UpdatePayeeRequest;
use App\Http\Requests\API\V1\Expense\UpdatePaymentMethodRequest;
use App\Http\Requests\API\V1\Expense\UpdateReimbursableRequest;
use App\Http\Requests\API\V1\Expense\UpdateSubCategoryRequest;
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
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;


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
    public function index(ExpenseFor $expenseFor)
    {
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

    /**
     * updateUser
     * @param \App\Models\Expense $expense
     * @param \App\Http\Requests\API\V1\Expense\UpdateUserRequest $updateUserRequest
     * @return JsonResponse
     */
    public function updateUser(Expense $expense, UpdateUserRequest $updateUserRequest): JsonResponse
    {
        try {
            Gate::authorize('update', $expense);
            $validatedData = $updateUserRequest->validated();
            $this->expenseService->updateUser($expense->id, $validatedData['user_id']);
            return $this->success(200, 'User Updated Successfully');
        } catch (Exception $e) {
            Log::error('ExpenseController::updateUser', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * updateCategory
     * @param \App\Models\Expense $expense
     * @param \App\Http\Requests\API\V1\Expense\UpdateCategoryRequest $updateCategoryRequest
     * @return JsonResponse
     */
    public function updateCategory(Expense $expense, UpdateCategoryRequest $updateCategoryRequest): JsonResponse
    {
        try {
            Gate::authorize('update', $expense);
            $validatedData = $updateCategoryRequest->validated();
            $this->expenseService->updateCategory($expense->id, $validatedData['category_id']);
            return $this->success(200, 'Category Updated Successfully');
        } catch (Exception $e) {
            Log::error('ExpenseController::updateCategory', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * updateSubCategory
     * @param \App\Models\Expense $expense
     * @param \App\Http\Requests\API\V1\Expense\UpdateSubCategoryRequest $updateSubCategoryRequest
     * @return JsonResponse
     */
    public function updateSubCategory(Expense $expense, UpdateSubCategoryRequest $updateSubCategoryRequest): JsonResponse
    {
        try {
            Gate::authorize('update', $expense);
            $validatedData = $updateSubCategoryRequest->validated();
            $this->expenseService->updateSubCategory($expense->id, $validatedData['sub_category_id']);
            return $this->success(200, 'Sub Category Updated Successfully');
        } catch (Exception $e) {
            Log::error('ExpenseController::updateSubCategory', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * updateDescription
     * @param \App\Models\Expense $expense
     * @param \App\Http\Requests\API\V1\Expense\UpdateDescriptionRequest $updateDescriptionRequest
     * @return JsonResponse
     */
    public function updateDescription(Expense $expense, UpdateDescriptionRequest $updateDescriptionRequest): JsonResponse
    {
        try {
            Gate::authorize('update', $expense);
            $validatedData = $updateDescriptionRequest->validated();
            $this->expenseService->updateDescription($expense->id, $validatedData['description']);
            return $this->success(200, 'Description Updated Successfully');
        } catch (Exception $e) {
            Log::error('ExpenseController::updateDescription', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * updateAmount
     * @param \App\Models\Expense $expense
     * @param \App\Http\Requests\API\V1\Expense\UpdateAmountRequest $updateAmountRequest
     * @return JsonResponse
     */
    public function updateAmount(Expense $expense, UpdateAmountRequest $updateAmountRequest): JsonResponse
    {
        try {
            Gate::authorize('update', $expense);
            $validatedData = $updateAmountRequest->validated();
            $this->expenseService->updateAmount($expense->id, $validatedData['amount']);
            return $this->success(200, 'Amount Updated Successfully');
        } catch (Exception $e) {
            Log::error('ExpenseController::updateAmount', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * updatePaymentMethod
     * @param \App\Models\Expense $expense
     * @param \App\Http\Requests\API\V1\Expense\UpdatePaymentMethodRequest $updatePaymentMethodRequest
     * @return JsonResponse
     */
    public function updatePaymentMethod(Expense $expense, UpdatePaymentMethodRequest $updatePaymentMethodRequest): JsonResponse
    {
        try {
            Gate::authorize('update', $expense);
            $validatedData = $updatePaymentMethodRequest->validated();
            $this->expenseService->updatePaymentMethod($expense->id, $validatedData['payment_method_id']);
            return $this->success(200, 'Payment Method Updated');
        } catch (Exception $e) {
            Log::error('ExpenseController::updatePaymentMethod', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * updatePayee
     * @param \App\Models\Expense $expense
     * @param \App\Http\Requests\API\V1\Expense\UpdatePayeeRequest $updatePayeeRequest
     * @return JsonResponse
     */
    public function updatePayee(Expense $expense, UpdatePayeeRequest $updatePayeeRequest): JsonResponse
    {
        try {
            Gate::authorize('update', $expense);
            $validatedData = $updatePayeeRequest->validated();
            $this->expenseService->updatePayee($expense->id, $validatedData['payee']);
            return $this->success(200, 'Payee Updated Successfully');
        } catch (Exception $e) {
            Log::error('ExpenseController::updatePayee', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * updateReimbursable
     * @param \App\Models\Expense $expense
     * @return JsonResponse
     */
    public function updateReimbursable(Expense $expense): JsonResponse
    {
        try {
            Gate::authorize('update', $expense);
            $this->expenseService->updateReimbursable($expense->id);
            return $this->success(200, 'Reimburables Updated Successfully');
        } catch (Exception $e) {
            Log::error('ExpenseController::updateReimbursable', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * updateListing
     * @param \App\Models\Expense $expense
     * @param \App\Http\Requests\API\V1\Expense\UpdateListingRequest $updateListingRequest
     * @return JsonResponse
     */
    public function updateListing(Expense $expense, UpdateListingRequest $updateListingRequest): JsonResponse
    {
        try {
            Gate::authorize('update', $expense);
            $validatedData = $updateListingRequest->validated();
            $this->expenseService->updateListing($expense->id, $validatedData['listing']);
            return $this->success(200, 'Listing Updated Successfully');
        } catch (Exception $e) {
            Log::error('ExpenseController::updateListing', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * updateNote
     * @param \App\Models\Expense $expense
     * @param \App\Http\Requests\API\V1\Expense\UpdateNoteRequest $updateNoteRequest
     * @return JsonResponse
     */
    public function updateNote(Expense $expense, UpdateNoteRequest $updateNoteRequest): JsonResponse
    {
        try {
            Gate::authorize('update', $expense);
            $validatedData = $updateNoteRequest->validated();
            $this->expenseService->updateNote($expense->id, $validatedData['note']);
            return $this->success(200, 'Note Updated Successfully');
        } catch (Exception $e) {
            Log::error('ExpenseController::updateNote', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
