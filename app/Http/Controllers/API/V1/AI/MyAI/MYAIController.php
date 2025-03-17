<?php

namespace App\Http\Controllers\API\V1\AI\MyAI;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\AI\MessageRequest;
use App\Http\Resources\API\V1\AI\CreateChatMessageResource;
use App\Http\Resources\API\V1\AI\CreateChatResource;
use App\Models\MyAI;
use App\Services\API\V1\AI\MyAI\MyAIService;
use App\Services\API\V1\AI\OpenAIService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class MyAIController extends Controller
{
        protected MyAIService $myaiService;

    /**
     * construct
     * @param \App\Services\API\V1\AI\MyAI\MYAIService $myaiService
     */
    public function __construct(MyAIService $myaiService)
    {
        $this->myaiService = $myaiService;
    }

    /**
     * index
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $resource = $this->myaiService->getChat();
            return $this->success(200, 'All Chats.', $resource);
        } catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\AI\MyAI\MyAIController::index', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error.', $e->getMessage());
        }
    }

    /**
     * storeChat
     * @param \App\Http\Requests\API\V1\AI\MessageRequest $messageRequest
     * @return JsonResponse
     */
    public function storeChat(MessageRequest $messageRequest)
    {
        try {
            $validatedData = $messageRequest->validated();
            $message = $validatedData['message'];
            $response = $this->myaiService->createNewChat($message);
            return $this->success(200,'Chat created successfully.', new CreateChatResource($response));
        } catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\AI\MyAI\MyAIController::storeChat', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error.', $e->getMessage());
        }
    }

    /**
     * show
     * @param \App\Models\MyAI $myAI
     * @return JsonResponse
     */
    public function show(MyAI $myAI): JsonResponse
    {
        try {
            $resource = $this->myaiService->getChatMessages($myAI->id);
            return $this->success(200, 'All messages.', $resource);
        } catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\AI\MyAI\MyAIController::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error.', $e->getMessage());
        }
    }

    /**
     * save message
     * @param \App\Http\Requests\API\V1\AI\MessageRequest $messageRequest
     * @param \App\Models\MyAI $myAI
     * @return JsonResponse
     */
    public function message(MessageRequest $messageRequest,MyAI $myAI): JsonResponse
    {
        try {
            $validatedData = $messageRequest->validated();
            $message = $validatedData['message'];
            $response = $this->myaiService->saveChat($myAI->id, $message);
            return $this->success(200, 'All Chats.', new CreateChatMessageResource($response));
        } catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\AI\MyAI\MyAIController::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error.', $e->getMessage());
        }
    }
}
