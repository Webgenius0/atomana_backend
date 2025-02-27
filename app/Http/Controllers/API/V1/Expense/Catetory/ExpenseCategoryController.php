<?php

namespace App\Http\Controllers\API\V1\Expense\Catetory;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Expense\Category\CreateRequest;
use App\Http\Resources\Api\V1\Expense\Category\StoreResource;
use App\Services\API\V1\Expense\Catetory\ExpenseCategoryService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExpenseCategoryController extends Controller
{
    use ApiResponse;
    protected ExpenseCategoryService $expenseCategoryService;

    /**
     * __construct
     */
    public function __construct(ExpenseCategoryService $expenseCategoryService)
    {
        $this->expenseCategoryService = $expenseCategoryService;
    }

    /**
     * index of categories
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $response = $this->expenseCategoryService->getCategories();
            return $this->success(200, 'All Expense Categoryes', $response);
        } catch (Exception $e) {
            Log::error('ExpenseCategoryController::index', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }


    /**
     * store
     * @param CreateRequest $createRequest
     * @return JsonResponse
     */
    public function store(CreateRequest $createRequest): JsonResponse
    {
        try {
            $validatedData = $createRequest->validated();
            $response = $this->expenseCategoryService->create($validatedData);
            return $this->success(201, 'Category Created Successfully', new StoreResource($response));
        } catch (Exception $e) {
            Log::error('ExpenseCategoryController::index', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }


    /**
     * search
     * @return JsonResponse
     */
    public function search(): JsonResponse
    {
        try {
            $response = $this->expenseCategoryService->search();
            return $this->success(201, 'Category Created Successfully', $response);
        } catch (Exception $e) {
            Log::error('ExpenseCategoryController::index', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
