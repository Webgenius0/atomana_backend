<?php

namespace App\Http\Controllers\API\V1\OpenHouse;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\OpenHouse\CreateRequest;
use App\Http\Resources\API\V1\OpenHouse\CreateResource;
use App\Http\Resources\API\V1\OpenHouse\DropdownResource;
use App\Http\Resources\API\V1\OpenHouse\IndexResource;
use App\Models\OpenHouse;
use App\Services\API\V1\OpenHouse\OpenHouseService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OpenHouseController extends Controller
{
    protected OpenHouseService $openHouseService;

    public function __construct(OpenHouseService $openHouseService)
    {
        $this->openHouseService = $openHouseService;
    }

    /**
     * index
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response = $this->openHouseService->list();
            return $this->success(200, 'Request Success', new IndexResource($response));
        } catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\OpenHouse::index', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * store
     * @param \App\Http\Requests\API\V1\OpenHouse\CreateRequest $createRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRequest $createRequest): JsonResponse
    {
        try {
            $validatedData = $createRequest->validated();
            $response = $this->openHouseService->store($validatedData);
            return $this->success(201, 'Open House Created Successfully', new CreateResource($response));
        } catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\OpenHouse::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * show
     * @param \App\Models\OpenHouse $openHouse
     * @return JsonResponse
     */
    public function show(OpenHouse $openHouse)
    {
        try {
            $response = $this->openHouseService->showOpenHouse($openHouse);
            return $this->success(201, 'Getting OpenHouse with feedbacks', $response);
        } catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\OpenHouse::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * dropdownIndex
     * @return JsonResponse
     */
    public function dropdownIndex(): JsonResponse
    {
        try {
            $response = $this->openHouseService->dropdown();
            return $this->success(201, 'Open House Created Successfully', new DropdownResource($response));
        } catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\OpenHouse::dropdownIndex', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
