<?php

namespace App\Http\Controllers\API\V1\AI\MyPR;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\AI\MessageRequest;
use App\Http\Resources\API\V1\AI\CreateChatResource;
use App\Http\Resources\API\V1\AI\CreatePRChatMessageResource;
use App\Models\MyPR;
use App\Services\API\V1\AI\MyPR\MyPRService;
use App\Services\API\V1\AI\OpenAIService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MyPRController extends Controller
{
    protected MyPRService $myprService;

    /**
     * construct
     * @param \App\Services\API\V1\AI\MyAI\MYAIService $myaiService
     */
    public function __construct(MyPRService $myprService)
    {
        $this->myprService = $myprService;
    }

    /**
     * index
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $resource = $this->myprService->getChat();
            return $this->success(200, 'All Chats.', $resource);
        } catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\AI\MyPR\MyPRController::index', ['error' => $e->getMessage()]);
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
            $response = $this->myprService->createNewChat($message);
            return $this->success(200,'Chat created successfully.', new CreateChatResource($response));
        } catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\AI\MyPR\MyPRController::storeChat', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error.', $e->getMessage());
        }
    }

    /**
     * show
     * @param \App\Models\MyPR $myPR
     * @return JsonResponse
     */
    public function show(MyPR $myPR): JsonResponse
    {
        try {
            $resource = $this->myprService->getChatMessages($myPR->id);
            return $this->success(200, 'All messages.', $resource);
        } catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\AI\MyPR\MyPRController::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error.', $e->getMessage());
        }
    }

    /**
     * save message
     * @param \App\Http\Requests\API\V1\AI\MessageRequest $messageRequest
     * @param \App\Models\MyPR $myPR
     * @return JsonResponse
     */
    public function message(MessageRequest $messageRequest,MyPR $myPR): JsonResponse
    {
        try {
            $validatedData = $messageRequest->validated();
            $message = $validatedData['message'];
            $response = $this->myprService->saveChat($myPR->id, $message);
            return $this->success(200, 'All Chats.', new CreatePRChatMessageResource($response));
        } catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\AI\MyPR\MyPRController::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error.', $e->getMessage());
        }
    }
}
