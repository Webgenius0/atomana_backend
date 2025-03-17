<?php

namespace App\Repositories\API\V1\AI\MyPR;

use App\Models\MyPRMessage;
use Exception;
use Illuminate\Support\Facades\Log;

class MyPRMessageRepository implements MyPRMessageRepositoryInterface
{
    /**
     * saveChat
     * @param int $MyAIId
     * @param string $message
     * @param string $response
     * @return MyPRMessage
     */
    public function saveChat(int $myAIId, string $message, string $response): MyPRMessage
    {
        try {
            return MyPRMessage::create([
                'my_a_i_id' => $myAIId,
                'message' => $message,
                'response' => $response,
            ]);
        } catch (Exception $e) {
            Log::error('App\Repositories\API\V1\AI\MyPR\MyPRMessageRepository::saveChat', ['error' => $e->getMessage()]);
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
            return MyPRMessage::select('id', 'message', 'response')->whereMyAIId($MyAIId)->latest()->paginate(10);
        } catch (Exception $e) {
            Log::error('App\Repositories\API\V1\AI\MyPR\MyPRMessageRepository::getChets', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
