<?php

namespace App\Http\Controllers\API\V1\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Contract\CreateRequest;
use App\Http\Requests\API\V1\Contract\DeleteRequest;
use App\Services\API\V1\Contract\ContractService;
use App\Http\Resources\API\V1\Contract\StoreResource;
use App\Models\Contract;
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

            return $this->success(200, 'contract index', $response);
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

    /**
     * show
     * @param \App\Models\Contract $contract
     * @return JsonResponse
     */
    public function show(Contract $contract): JsonResponse
    {
        try {
            $response = $this->contractService->showContract($contract->id);
            return $this->success(200, 'contract', $response);
        } catch (Exception $e) {
            Log::error('ContractController::store', ['message' => $e->getMessage()]);
            return $this->error(500, 'server error', $e->getMessage());
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
            $this->contractService->bulkDestory($ids);
            return $this->success(201, 'deleted');
        } catch (Exception $e) {
            Log::error('ContractController::bulkDelete', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
