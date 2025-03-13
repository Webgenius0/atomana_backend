<?php

namespace App\Http\Controllers\API\V1\VendorCategory;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\VendorCategory\CreateRequest;
use App\Services\API\V1\VendorCategory\VendorCategoryService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VendorCategoryController extends Controller
{
    use ApiResponse;
    protected VendorCategoryService $vendorCategoryService;

    /**
     * construct
     * @param VendorCategoryService $vendorCategoryService
     */
    public function __construct(VendorCategoryService $vendorCategoryService)
    {
        $this->vendorCategoryService = $vendorCategoryService;
    }


    /**
     * Sales Track index of the business.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $response = $this->vendorCategoryService->getVendorCategory();
            return $this->success(200, 'Vendor Categories', $response);
        } catch (Exception $e) {
            Log::error('VendorCategoryController::index', ['error' => $e->getMessage()]);
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
            $response = $this->vendorCategoryService->storeVendorCategory($validatedData);
            return $this->success(201, 'Vendor Category Created Successfully', $response);
        } catch (Exception $e) {
            Log::error('VendorCategoryController::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }


    /**
     * Show the specified vendor category.
     *
     * @param string $categorySlug
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $categorySlug): JsonResponse
    {
        try {
            $response = $this->vendorCategoryService->getVendorCategoryBySlug($categorySlug);
            return $this->success(200, 'Vendor Category Details', $response);
        } catch (Exception $e) {
            Log::error('VendorCategoryController::show', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
