<?php

namespace App\Http\Controllers\API\V1\Expense\SubCatetory;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Expense\SubCategory\CreateRequest;
use App\Http\Resources\API\V1\Expense\SubCategory\CreateResponse;
use App\Http\Resources\API\V1\Expense\SubCategory\ExpenseSubCategoryResource;
use App\Models\ExpenseCategory;
use App\Services\API\V1\Expense\SubCatetory\ExpenseSubCategoryService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ExpenseSubCategoryController extends Controller
{
    protected ExpenseSubCategoryService $expenseSubCategoryService;

    /**
     * __construct
     * @param \App\Services\API\V1\Expense\SubCatetory\ExpenseSubCategoryService $expenseSubCategoryService
     */
    public function __construct(ExpenseSubCategoryService $expenseSubCategoryService)
    {
        $this->expenseSubCategoryService = $expenseSubCategoryService;
    }

    /**
     * get all subcagegoryes of the category
     * @param \App\Models\ExpenseCategory $expenseCategory
     * @return JsonResponse
     */
    public function index(ExpenseCategory $expenseCategory): JsonResponse
    {
        try {
            $response = $this->expenseSubCategoryService->getSubCagegories($expenseCategory);
            return $this->success(
                200,
                'All Expense Sub Categoryes of Category ' . $expenseCategory->name,
                new ExpenseSubCategoryResource($response)
            );
        } catch (ModelNotFoundException $modelNotFoundException) {
            return $this->error(500, 'Cagegory Not Found..!', $modelNotFoundException->getMessage());
        } catch (Exception $e) {
            Log::error('ExpenseSubCategoryController::index', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }


    /**
     * store
     * @param \App\Http\Requests\API\V1\Expense\SubCategory\CreateRequest $createRequest
     * @return JsonResponse
     */
    public function store(CreateRequest $createRequest): JsonResponse
    {
        try {
            $validatedData = $createRequest->validated();
            $response = $this->expenseSubCategoryService->storeSubCategory($validatedData);
            return $this->success(
                200,
                'Sub Category Created Successfully.',
                new CreateResponse($response)
            );
        } catch (Exception $e) {
            Log::error('ExpenseSubCategoryController::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
