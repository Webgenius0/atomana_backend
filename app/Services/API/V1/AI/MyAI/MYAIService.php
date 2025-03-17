<?php

namespace App\Services\API\V1\AI\MyAI;

use App\Models\MyAI;
use App\Models\MyAIMessage;
use App\Repositories\API\V1\AI\MyAI\MyAIMessageRepositoryInterface;
use App\Repositories\API\V1\AI\MyAI\MyAIRepositoryInterface;
use App\Services\API\V1\AI\OpenAIService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MyAIService
{
    protected MyAIRepositoryInterface $myAIRepository;
    protected MyAIMessageRepositoryInterface $myAIMessageRepository;
    protected OpenAIService $openAIService;
    protected $user;

    /**
     * construct
     * @param \App\Repositories\API\V1\AI\MyAI\MyAIRepositoryInterface $myAIRepository
     * @param \App\Repositories\API\V1\AI\MyAI\MyAIMessageRepositoryInterface $myAIMessageRepository
     * @param \App\Services\API\V1\AI\OpenAIService $openAIService
     */
    public function __construct(MyAIRepositoryInterface $myAIRepository, MyAIMessageRepositoryInterface $myAIMessageRepository, OpenAIService $openAIService)
    {
        $this->myAIRepository = $myAIRepository;
        $this->myAIMessageRepository = $myAIMessageRepository;
        $this->openAIService = $openAIService;
        $this->user = Auth::user();
    }

    /**
     * getChat
     */
    public function getChat()
    {
        try {
            return $this->myAIRepository->getChats($this->user->id);
        } catch (Exception $e) {
            Log::error('App\Services\API\V1\AI\MyAI\MYAIService::getMessageList', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * createNewChat
     * @param string $message
     * @throws Exception
     * @return array{message: mixed, message_id: mixed, new_chat_id: mixed, new_chat_name: mixed, response: mixed}
     */
    public function createNewChat(string $message):array
    {
        try {
            $response = $this->openAIService->chat($message);
            if (isset($response['id']))
            {
                $responseMessage = $response['choices'][0]['message']['content'];

                $newChat = $this->myAIRepository->createChat($this->user->id, substr($responseMessage, 0, 10). '...');
                $message = $this->myAIMessageRepository->saveChat($newChat->id, $message, $responseMessage,);
                return [
                    $newChat,
                    $message
                ];
            }
            throw new Exception($response);
        } catch (Exception $e) {
            Log::error('App\Services\API\V1\AI\MyAI\MYAIService::createNewChat', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * getChatMessages
     * @param int $myAIId
     */
    public function getChatMessages(int $myAIId)
    {
        try {
            return $this->myAIMessageRepository->getChets($myAIId);
        } catch (Exception $e) {
            Log::error('App\Services\API\V1\AI\MyAI\MYAIService::getMessageChat', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * saveChat
     * @param \App\Models\MyAI $myAI
     * @param string $message
     * @throws \Exception
     * @return MyAIMessage
     */
    public function saveChat(int $myAIId, string $message):MyAIMessage
    {
        try {
            $response = $this->openAIService->chat($message);
            if (isset($response['id']))
            {
                $responseMessage = $response['choices'][0]['message']['content'];

                $message = $this->myAIMessageRepository->saveChat($myAIId, $message, $responseMessage,);
                return $message;
            }
            throw new Exception($response);
        } catch (Exception $e) {
            Log::error('App\Services\API\V1\AI\MyAI\MYAIService::saveChat', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
