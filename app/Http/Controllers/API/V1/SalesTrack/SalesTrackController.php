<?php

namespace App\Http\Controllers\API\V1\SalesTrake;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\SalesTrack\CreateSalesTrackRequest;
use App\Services\API\V1\SalesTrake\SalesTrackService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SalesTrackController extends Controller
{
    use ApiResponse;
    protected SalesTrackService $salesTrackService;

    /**
     * construct
     * @param \App\Services\API\V1\SalesTrake\SalesTrackService $salesTrackService
     */
    public function __construct(SalesTrackService $salesTrackService)
    {
        $this->salesTrackService = $salesTrackService;
    }

    /**
     * store
     * @param \App\Http\Requests\API\V1\SalesTrack\CreateSalesTrackRequest $createSalesTrackRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateSalesTrackRequest $createSalesTrackRequest)
    {
        try {
            $validatedData = $createSalesTrackRequest->validated();
            $response = $this->salesTrackService->storeSalesTrack($validatedData);
            return $this->success(201, 'Sales Track Created', $response);
        } catch (Exception $e) {
            Log::error('SalesTrackController::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
