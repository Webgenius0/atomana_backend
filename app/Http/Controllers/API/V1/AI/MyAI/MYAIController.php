<?php

namespace App\Http\Controllers\API\V1\AI\MyAI;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\AI\MessageRequest;
use App\Models\MyAI;
use App\Services\API\V1\AI\MyAI\MyAIService;
use App\Services\API\V1\AI\OpenAIService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MyAIController extends Controller
{
    protected OpenAIService $openAIService;
    protected MyAIService $myaiService;

    /**
     * construct
     * @param \App\Services\API\V1\AI\OpenAIService $openAIService
     * @param \App\Services\API\V1\AI\MyAI\MYAIService $myaiService
     */
    public function __construct(OpenAIService $openAIService, MyAIService $myaiService)
    {
        $this->openAIService = $openAIService;
        $this->myaiService = $myaiService;
    }


    public function index(): JsonResponse
    {
        try {
            return $this->success(200, 'All Chats.');
        } catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\AI\MyAIController::index', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error.', $e->getMessage());
        }
    }

    /**
     * create new chat
     * @param \App\Http\Requests\API\V1\AI\MessageRequest $messageRequest
     * @return JsonResponse
     */
    public function store(MessageRequest $messageRequest)
    {
        try {
            $validatedData = $messageRequest->validated();
            $message = $validatedData['message'];
            $response = $this->myaiService->createNewChat($message);
            return $this->success(200,'Chat created successfully.', $response);
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
