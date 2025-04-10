<?php

namespace App\Http\Controllers\API\V1\Property\AccessInstruction;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Property\AccessInstruction\CreateRequest;
use App\Http\Resources\API\V1\Property\AccessInstruction\StoreResource;
use App\Http\Resources\API\V1\Property\AccessInstruction\IndexResource;
use App\Models\PropertyAccessInstruction;
use App\Services\API\V1\Property\AccessInstruction\AccessInstructionService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;

class AccessInstructionController extends Controller
{
    private AccessInstructionService $accessInstructionService;

    /**
     * construct
     * @param \App\Services\API\V1\Property\AccessInstruction\AccessInstructionService $accessInstructionService
     */
    public function __construct(AccessInstructionService $accessInstructionService)
    {
        $this->accessInstructionService = $accessInstructionService;
    }

    /**
     * index
     * @return \Illuminate\Http\JsonResponse
     */
    public function index():JsonResponse
    {
        try {
            $response = $this->accessInstructionService->getIndex();
            return $this->success(200, 'List of Property Access Instruciton', new IndexResource($response));
        }catch (Exception $e){
            Log::error('AccessInstructionController::index', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     *store
     * @param \App\Http\Requests\API\V1\Property\AccessInstruction\CreateRequest $createRequest
     * @return JsonResponse
     */
    public function store(CreateRequest $createRequest):JsonResponse
    {
        try {
            $validatedData = $createRequest->validated();
            $response = $this->accessInstructionService->createAccessInstruction($validatedData);
            return $this->success(200, 'Created Successfully.', new StoreResource($response));
        }catch (PreconditionFailedHttpException $e) {
            throw $e;
        }catch (Exception $e){
            Log::error('AccessInstructionController::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error.', $e->getMessage());
        }
    }

    /**
     * show
     * @param \App\Models\PropertyAccessInstruction $propertyAccessInstruction
     * @return JsonResponse
     */
    public function show(PropertyAccessInstruction $propertyAccessInstruction):JsonResponse
    {
        try {
            $response = $this->accessInstructionService->showSingleAccessInstruction($propertyAccessInstruction->id);
            return $this->success(200, 'Created Successfully.', $response);
        }catch (Exception $e){
            Log::error('AccessInstructionController::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error.', $e->getMessage());
        }
    }
}
