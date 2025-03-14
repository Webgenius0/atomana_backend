<?php

namespace App\Http\Controllers\API\V1\VendorReview;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\VendorReview\CreateRequest;
use App\Services\API\V1\VendorReview\VendorReviewService;
use App\Traits\V1\ApiResponse;
use Exception;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VendorReviewController extends Controller
{
    use ApiResponse;
    protected VendorReviewService $vendorReviewService;

    public function __construct(VendorReviewService $vendorReviewService)
    {
        $this->vendorReviewService = $vendorReviewService;
    }

    /**
     * Store a newly created vendor review in storage.
     *
     * @param  \App\Http\Requests\API\V1\VendorReview\CreateRequest  $createRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRequest $createRequest)
    {
        try {
            $validatedData = $createRequest->validated();
            $response = $this->vendorReviewService->storeReview($validatedData);
            return $this->success(201, 'Vendor Review created successfully', $response);
        } catch (Exception $e) {
            Log::error('VendorReviewController::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    public function show(string $vendorSlug)
    {
        try {
            $response = $this->vendorReviewService->getReviewsByVendorSlug($vendorSlug);
            return $this->success(200, 'Vendor Reviews fatched successfully', $response);
        } catch (Exception $e) {
            Log::error('VendorReviewController::index', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
