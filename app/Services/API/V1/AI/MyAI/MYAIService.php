<?php

namespace App\Services\API\V1\AI\MyAI;

use App\Repositories\API\V1\AI\MyAI\MYAIMessageRepositoryInterface;
use App\Repositories\API\V1\AI\MyAI\MYAIRepositoryInterface;
use App\Services\API\V1\AI\OpenAIService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MYAIService
{
    protected MYAIRepositoryInterface $myAIRepository;
    protected MYAIMessageRepositoryInterface $myAIMessageRepository;
    protected OpenAIService $openAIService;
    protected $user;

    /**
     * construct
     * @param \App\Repositories\API\V1\AI\MyAI\MYAIRepositoryInterface $myAIRepository
     * @param \App\Repositories\API\V1\AI\MyAI\MYAIMessageRepositoryInterface $myAIMessageRepository
     * @param \App\Services\API\V1\AI\OpenAIService $openAIService
     */
    public function __construct(MYAIRepositoryInterface $myAIRepository, MYAIMessageRepositoryInterface $myAIMessageRepository, OpenAIService $openAIService)
    {
        $this->myAIRepository = $myAIRepository;
        $this->myAIMessageRepository = $myAIMessageRepository;
        $this->openAIService = $openAIService;
        $this->user = Auth::user();
    }

    public function createNewMessage(string $message)
    {
        try {
            $response = $this->openAIService->chat($message);
            if (isset($response['id']))
            {
                $responseMessage = $response['choices'][0]['message']['content'];
                
            }
            throw new Exception($response);
        } catch (Exception $e) {
            Log::error('App\Services\API\V1\AI\MyAI\MYAIService::createNewMessage', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function saveChat()
    {
        try {
        } catch (Exception $e) {
            Log::error('App\Services\API\V1\AI\MyAI\MYAIService::saveChat', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    public function getMessageList()
    {
        try {
        } catch (Exception $e) {
            Log::error('App\Services\API\V1\AI\MyAI\MYAIService::getMessageList', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function getMessageChat()
    {
        try {
        } catch (Exception $e) {
            Log::error('App\Services\API\V1\AI\MyAI\MYAIService::getMessageChat', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
