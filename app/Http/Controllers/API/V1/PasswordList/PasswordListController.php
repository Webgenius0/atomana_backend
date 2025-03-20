<?php

namespace App\Http\Controllers\API\V1\PasswordList;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\PasswordList\CreateRequest;
use App\Services\API\V1\PasswordList\PasswordListService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PasswordListController extends Controller
{
    use ApiResponse;
    protected PasswordListService $passwordListService;

    public function __construct(PasswordListService $passwordListService)
    {
        $this->passwordListService = $passwordListService;
    }

    public function index(): JsonResponse
    {
        try {
            $response = $this->passwordListService->getAllPassword();
            return $this->success(200, 'Password lists faced successfully', $response);
        } catch (Exception $e) {
            Log::error($e);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    public function store(CreateRequest $createRequest): JsonResponse
    {
        try {
            $validatedData = $createRequest->validated();
            $response = $this->passwordListService->createPassword($validatedData);
            return $this->success(201, 'New password added to password lists ', $response);
        } catch (Exception $e) {
            Log::error($e);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    public function show(string $passwordListSlug): JsonResponse
    {
        try {
            $response = $this->passwordListService->getPassword($passwordListSlug);
            return $this->success(200, 'Password lists faced successfully', $response);
        } catch (Exception $e) {
            Log::error($e);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
