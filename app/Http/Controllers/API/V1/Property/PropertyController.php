<?php

namespace App\Http\Controllers\API\V1\Property;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Property\CreatePropertyRequest;
use App\Http\Requests\API\V1\Property\DeleteRequest;
use App\Http\Requests\API\V1\Property\UpdateCommisionRateRequest;
use App\Http\Requests\API\V1\Property\UpdatePriceRequest;
use App\Http\Requests\Api\V1\Property\UpdateRequest;
use App\Http\Resources\API\V1\Property\CreatePropertyResource;
use App\Models\Property;
use App\Services\API\V1\Property\PropertyService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PropertyController extends Controller
{
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
     * index
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $response = $this->propertyService->propertyesOfBusiness();
            return $this->success(200, 'Property List', $response);
        } catch (Exception $e) {
            Log::error('PropertyController::index', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
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
        } catch (Exception $e) {
            Log::error('PropertyController::dropdown', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * store properties
     * @param \App\Http\Requests\API\V1\Property\CreatePropertyRequest $createPropertyRequest
     * @return JsonResponse
     */
    public function store(CreatePropertyRequest $createPropertyRequest): JsonResponse
    {
        try {
            $validatedData = $createPropertyRequest->validated();
            $response = $this->propertyService->storeProperty($validatedData);
            return $this->success(201, 'property created');
        } catch (Exception $e) {
            Log::error('PropertyController::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * Show
     * @param int $propertyid
     * @return JsonResponse
     */
    public function show(int $propertyid): JsonResponse
    {
        try {
            $response = $this->propertyService->showPropertyDetails($propertyid);
            return $this->success(200, 'Property Details', $response);
        } catch (Exception $e) {
            Log::error('PropertyController::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * update
     * @param \App\Http\Requests\Api\V1\Property\UpdateRequest $updateRequest
     * @param \App\Models\Property $property
     * @return JsonResponse
     */
    public function update(UpdateRequest $updateRequest, Property $property): JsonResponse
    {
        try {
            $validatedData = $updateRequest->validated();
            $this->propertyService->updateProperty($property, $validatedData);
            return $this->success(200, 'updated');
        }catch (Exception $e) {
            Log::error('PropertyController::update', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }


    /**
     * bulkDelete
     * @param \App\Http\Requests\API\V1\OpenHouse\DeleteRequest $deleteRequest
     * @return JsonResponse
     */
    public function bulkDelete(DeleteRequest $deleteRequest)
    {
        try {
            $ids = $deleteRequest->input('id');
            $this->propertyService->bulkDestory($ids);
            return $this->success(200, 'deleted');
        } catch (Exception $e) {
            Log::error('PropertyController::bulkDelete', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

}
