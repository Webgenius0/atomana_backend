<?php

namespace App\Http\Controllers\API\V1\AI;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\AI\MessageRequest;
use App\Http\Resources\API\V1\AI\MessageResource;
use App\Services\API\V1\AI\OpenAIService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MyAIController extends Controller
{
    protected $openAIService;

    /**
     * construct
     * @param \App\Services\API\V1\AI\OpenAIService $openAIService
     */
    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    /**
     * chat
     * @param \App\Http\Requests\API\V1\AI\MessageRequest $messageRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function chat(MessageRequest $messageRequest): JsonResponse
    {
        try {
            $validatedData = $messageRequest->validated();

            $message = $validatedData['message'];

            $response = $this->openAIService->chat($message);

            return $this->success(200, 'Success.', new MessageResource($response));
        } catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\AI\MyAIController::chat', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error.', $e->getMessage());
        }
    }

}
