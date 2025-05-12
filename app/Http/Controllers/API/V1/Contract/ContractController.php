<?php

namespace App\Http\Controllers\API\V1\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Contract\CreateRequest;
use App\Services\API\V1\Contract\ContractService;
use Exception;
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

    public function index() {}

    /**
     * store
     * @param \App\Http\Requests\API\V1\Contract\CreateRequest $createRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRequest $createRequest)
    {
        try {
            $validatedData = $createRequest->validated();

            $response = $this->contractService->createContract($validatedData);

            return $this->success(201, 'contract created', $response);
        } catch (Exception $e) {
            Log::error('ContractController::store', ['message' => $e->getMessage()]);
            return $this->error(500, 'server error', $e->getMessage());
        }
    }
}
