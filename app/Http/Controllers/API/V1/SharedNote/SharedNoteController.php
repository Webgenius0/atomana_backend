<?php

namespace App\Http\Controllers\API\V1\SharedNote;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\SharedNote\CreateRequest;
use App\Services\API\V1\SharedNote\SharedNoteService;
use App\Traits\V1\ApiResponse;
use Exception;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SharedNoteController extends Controller
{
    use ApiResponse;
    protected SharedNoteService $sharedNoteService;

    public function __construct(SharedNoteService $sharedNoteService)
    {
        $this->sharedNoteService = $sharedNoteService;
    }

    public function index(): JsonResponse
    {
        try {
            $response = $this->sharedNoteService->getAllSharedNote();
            return $this->success(200, 'Shared notes faced successfully', $response);
        } catch (Exception $e) {
            Log::error($e);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    public function store(CreateRequest $createRequest): JsonResponse
    {
        try {
            $validatedData = $createRequest->validated();
            $response = $this->sharedNoteService->createSharedNote($validatedData);
            return $this->success(201, 'New shared note added to shared notes ', $response);
        } catch (Exception $e) {
            Log::error($e);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    public function show(string $SharedNoteSlug): JsonResponse
    {
        try {
            $response = $this->sharedNoteService->getSharedNote($SharedNoteSlug);
            return $this->success(200, 'Shared note faced successfully', $response);
        } catch (Exception $e) {
            Log::error($e);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    public function update(CreateRequest $createRequest, string $SharedNoteSlug): JsonResponse
    {
        try {
            $validatedData = $createRequest->validated();
            $response = $this->sharedNoteService->updateSharedNote($validatedData, $SharedNoteSlug);
            return $this->success(200, 'Shared note updated successfully', $response);
        } catch (Exception $e) {
            Log::error($e);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    public function destroy(string $SharedNoteSlug): JsonResponse
    {
        try {
            $response = $this->sharedNoteService->deleteSharedNote($SharedNoteSlug);
            return $this->success(200, 'Shared note deleted successfully');
        } catch (Exception $e) {
            Log::error($e);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }


}
