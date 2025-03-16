<?php

namespace App\Repositories\API\V1\AI\MyAI;

use App\Models\MyAIMessage;
use Exception;
use Illuminate\Support\Facades\Log;

class MyAIMessageRepository implements MyAIMessageRepositoryInterface
{
    /**
     * saveChat
     * @param int $MyAIId
     * @param string $message
     * @param string $response
     * @return MyAIMessage
     */
    public function saveChat(int $myAIId, string $message, string $response)
    {
        try {
            return MyAIMessage::create([
                'my_a_i_id' => $myAIId,
                'message' => $message,
                'response' => $response,
            ]);
        } catch (Exception $e) {
            Log::error('App\Repositories\API\V1\AI\MyAI\MYAIMessageRepository::saveChat', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * getChets
     * @param int $MyAIId
     */
    public function getChets(int $MyAIId)
    {
        try {
            return MyAIMessage::whereMyAIId($MyAIId)->get();
        } catch (Exception $e) {
            Log::error('App\Repositories\API\V1\AI\MyAI\MYAIMessageRepository::getChets', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
