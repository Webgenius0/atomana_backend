<?php

namespace App\Http\Controllers\API\V1\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Contract\CreateRequest;
use App\Services\API\V1\Contract\ContractService;
use App\Http\Resources\API\V1\Contract\StoreResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContractController extends Controller
{
    protected ContractService $contractService;

    /**
     * construct
     */
    public function __construct(ContractService $contractService)
    {
        $this->contractService = $contractService;
    }

    /**
     * index
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $response = $this->contractService->getAllContracts();

            return $this->success(201, 'contract created', $response);
        } catch (Exception $e) {
            Log::error('ContractController::index', ['message' => $e->getMessage()]);
            return $this->error(500, 'server error', $e->getMessage());
        }
    }

    /**
     * store
     * @param \App\Http\Requests\API\V1\Contract\CreateRequest $createRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRequest $createRequest): JsonResponse
    {
        try {
            $validatedData = $createRequest->validated();

            $response = $this->contractService->createContract($validatedData);

            return $this->success(201, 'contract created', new StoreResource($response));
        } catch (Exception $e) {
            Log::error('ContractController::store', ['message' => $e->getMessage()]);
            return $this->error(500, 'server error', $e->getMessage());
        }
    }
}
