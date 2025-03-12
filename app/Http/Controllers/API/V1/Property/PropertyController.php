<?php

namespace App\Http\Controllers\API\V1\Property;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Property\CreatePropertyRequest;
use App\Http\Resources\API\V1\Property\CreatePropertyResource;
use App\Services\API\V1\Property\PropertyService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PropertyController extends Controller
{
    use ApiResponse;
    protected PropertyService $propertyService;

    /**
     * construct
     * @param \App\Services\API\V1\Property\PropertyService $propertyService
     */
    public function __construct(PropertyService $propertyService)
    {
        $this->propertyService = $propertyService;
    }

    /**
     * dropdown shwo properties
     * @return \Illuminate\Http\JsonResponse
     */
    public function dropdown(): JsonResponse
    {
        try {
            $response = $this->propertyService->showDropdown();
            return $this->success(200, 'properties dropdown', $response);
        }catch (Exception $e) {
            Log::error('PropertyController::dropdown', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * store properties
     * @param \App\Http\Requests\API\V1\Property\CreatePropertyRequest $createPropertyRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreatePropertyRequest $createPropertyRequest):JsonResponse
    {
        try {
            $validatedData = $createPropertyRequest->validated();
            $response = $this->propertyService->storeProperty($validatedData);
            return $this->success(201, 'property created', new CreatePropertyResource($response));
        }catch (Exception $e) {
            Log::error('PropertyController::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

}
