<?php

namespace App\Http\Controllers\API\V1\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Vendor\CreateRequest;
use App\Http\Resources\API\V1\Vendor\VendorResource;
use App\Services\API\V1\Vendor\VendorService;
use App\Services\API\V1\VendorCategory\VendorCategoryService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class VendorController extends Controller
{
    use ApiResponse;
    protected VendorService $vendorService;

    /**
     * construct
     * @param VendorService $vendorService
     */
    public function __construct(VendorService $vendorService)
    {
        $this->vendorService = $vendorService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $response = $this->vendorService->getVendors();
            return $this->success(200, 'Vendors', VendorResource::collection($response));
        } catch (Exception $e) {
            Log::error('VendorController::index', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * Show the specified vendor category.
     *
     * @param string $VendorSlug
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $VendorSlug): JsonResponse
    {
        try {
            $response = $this->vendorService->getVendorBySlug($VendorSlug);
            return $this->success(200, 'Vendor Details', new VendorResource($response));
        } catch (Exception $e) {
            Log::error('VendorCategoryController::show', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * Store a newly created vendor in storage.
     *
     * @param  \App\Http\Requests\API\V1\Vendor\CreateRequest  $createRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRequest $createRequest): JsonResponse
    {
        try {
            $validatedData = $createRequest->validated();
            $response = $this->vendorService->storeVendor($validatedData);
            return $this->success(201, 'Vendor Created Successfully', $response);
        } catch (Exception $e) {
            Log::error('VendorController::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
