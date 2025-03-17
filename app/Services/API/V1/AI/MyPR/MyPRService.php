<?php

namespace App\Services\API\V1\AI\MyPR;

use App\Models\MyPRMessage;
use App\Repositories\API\V1\AI\MyPR\MyPRMessageRepositoryInterface;
use App\Repositories\API\V1\AI\MyPR\MyPRRepositoryInterface;
use App\Services\API\V1\AI\OpenAIService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MyPRService
{
    protected MyPRRepositoryInterface $myPRRepository;
    protected MyPRMessageRepositoryInterface $myPRMessageRepository;
    protected OpenAIService $openAIService;
    protected $user;

    /**
     * construct
     * @param \App\Repositories\API\V1\AI\MyPR\MyPRRepositoryInterface $myPRRepository
     * @param \App\Repositories\API\V1\AI\MyPR\MyPRMessageRepositoryInterface $myPRMessageRepository
     * @param \App\Services\API\V1\AI\OpenAIService $openAIService
     */
    public function __construct(MyPRRepositoryInterface $myPRRepository, MyPRMessageRepositoryInterface $myPRMessageRepository, OpenAIService $openAIService)
    {
        $this->myPRRepository = $myPRRepository;
        $this->myPRMessageRepository = $myPRMessageRepository;
        $this->openAIService = $openAIService;
        $this->user = Auth::user();
    }


    /**
     * getChat
     */
    public function getChat()
    {
        try {
            return $this->myPRRepository->getChats($this->user->id);
        } catch (Exception $e) {
            Log::error('App\Services\API\V1\AI\MyPR\MyPRService::getMessageList', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * createNewChat
     * @param string $message
     * @throws \Exception
     * @return array<MyPRMessage|\App\Models\MyPR>
     */
    public function createNewChat(string $message):array
    {
        try {
            $response = $this->openAIService->chat($message);
            if (isset($response['id']))
            {
                $responseMessage = $response['choices'][0]['message']['content'];

                $newChat = $this->myPRRepository->createChat($this->user->id, substr($responseMessage, 0, 10). '...');
                $message = $this->myPRMessageRepository->saveChat($newChat->id, $message, $responseMessage,);
                return [
                    $newChat,
                    $message
                ];
            }
            throw new Exception($response);
        } catch (Exception $e) {
            Log::error('App\Services\API\V1\AI\MyPR\MyPRService::createNewChat', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * getChatMessages
     * @param int $myPRId
     */
    public function getChatMessages(int $myPRId)
    {
        try {
            return $this->myPRMessageRepository->getChets($myPRId);
        } catch (Exception $e) {
            Log::error('App\Services\API\V1\AI\MyPR\MyPRService::getMessageChat', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * saveChat
     * @param int $myPRId
     * @param string $message
     * @throws \Exception
     * @return MyPRMessage
     */
    public function saveChat(int $myPRId, string $message):MyPRMessage
    {
        try {
            $response = $this->openAIService->chat($message);
            if (isset($response['id']))
            {
                $responseMessage = $response['choices'][0]['message']['content'];

                $message = $this->myPRMessageRepository->saveChat($myPRId, $message, $responseMessage);
                return $message;
            }
            throw new Exception($response);
        } catch (Exception $e) {
            Log::error('App\Services\API\V1\AI\MyPR\MyPRService::saveChat', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
