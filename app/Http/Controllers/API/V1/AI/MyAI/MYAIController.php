<?php

namespace App\Http\Controllers\API\V1\AI\MyAI;

use App\Http\Controllers\Controller;
use App\Models\MyAI;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MYAIController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            return $this->success(200, 'All Chats.');
        } catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\AI\MyAIController::index', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error.', $e->getMessage());
        }
    }

    public function store(): JsonResponse
    {
        try {
            return $this->success(200, 'All Chats.');
        } catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\AI\MyAIController::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error.', $e->getMessage());
        }
    }

    public function show(MyAI $myAI): JsonResponse
    {
        try {
            return $this->success(200, 'All Chats.');
        } catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\AI\MyAIController::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error.', $e->getMessage());
        }
    }


    public function chat(MyAI $myAI): JsonResponse
    {
        try {
            return $this->success(200, 'All Chats.');
        } catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\AI\MyAIController::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error.', $e->getMessage());
        }
    }
}
