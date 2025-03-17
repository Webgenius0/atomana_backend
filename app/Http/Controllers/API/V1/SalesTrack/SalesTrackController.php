<?php

namespace App\Http\Controllers\API\V1\SalesTrack;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\SalesTrack\CreateSalesTrackRequest;
use App\Http\Resources\API\V1\SalesTrack\CreateSalesTrackResource;
use App\Http\Resources\API\V1\SalesTrack\IndexSalesTrackResource;
use App\Services\API\V1\SalesTrack\SalesTrackService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SalesTrackController extends Controller
{
    protected SalesTrackService $salesTrackService;

    /**
     * construct
     * @param SalesTrackService $salesTrackService
     */
    public function __construct(SalesTrackService $salesTrackService)
    {
        $this->salesTrackService = $salesTrackService;
    }


    /**
     * Sales Track index of the business.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $response = $this->salesTrackService->getSalesTrack();
            return $this->success(201, 'Sales Tracks of the Business', new IndexSalesTrackResource($response));
        } catch (Exception $e) {
            Log::error('SalesTrackController::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * store
     * @param \App\Http\Requests\API\V1\SalesTrack\CreateSalesTrackRequest $createSalesTrackRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateSalesTrackRequest $createSalesTrackRequest): JsonResponse
    {
        try {
            $validatedData = $createSalesTrackRequest->validated();
            $response = $this->salesTrackService->storeSalesTrack($validatedData);
            return $this->success(201, 'Sales Track Created', new CreateSalesTrackResource($response));
        } catch (Exception $e) {
            Log::error('SalesTrackController::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
