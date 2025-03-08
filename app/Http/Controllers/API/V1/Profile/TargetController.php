<?php

namespace App\Http\Controllers\API\V1\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Target\StoreRequest;
use App\Http\Resources\API\V1\Target\CreateResource;
use App\Services\API\V1\Target\TargetService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TargetController extends Controller
{
    use ApiResponse;
    protected TargetService $targetService;
    /**
     * construct
     * @param \App\Services\API\V1\Target\TargetService $targetService
     */
    public function __construct(TargetService $targetService)
    {
        $this->targetService = $targetService;
    }

    /**
     * store
     * @param \App\Http\Requests\API\V1\Target\StoreRequest $storeRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $storeRequest): JsonResponse
    {
        try {
            Log::info($storeRequest->all());
            $validatedData = $storeRequest->validated();
            $response = $this->targetService->store($validatedData);
            return $this->success(200, 'Target Stored', new CreateResource($response));
        }catch(Exception $e) {
            Log::error('App\Http\Controllers\API\V1\Target\TargetController::store', ['error'  => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
