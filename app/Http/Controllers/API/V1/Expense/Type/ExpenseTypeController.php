<?php

namespace App\Http\Controllers\API\V1\Expense\Type;

use App\Http\Controllers\Controller;
use App\Services\API\V1\Expense\Type\ExpenseTypeService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExpenseTypeController extends Controller
{
    use ApiResponse;
    protected ExpenseTypeService $expenseTypeService;

    /**
     * __construct
     * @param \App\Services\API\V1\Expense\Type\ExpenseTypeService $expenseTypeService
     */
    public function __construct(ExpenseTypeService $expenseTypeService)
    {
        $this->expenseTypeService = $expenseTypeService;
    }



    /**
     * list of all expense types
     * @return JsonResponse
     */
    public function index():JsonResponse
    {
        try {
            $response = $this->expenseTypeService->getTypes();
            return $this->success(200, 'All Expense Types', $response);
        } catch (Exception $e) {
            Log::error('ExpenseTypeController::index', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
