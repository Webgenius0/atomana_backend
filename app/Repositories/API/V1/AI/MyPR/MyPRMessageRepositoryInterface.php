<?php

namespace App\Repositories\API\V1\AI\MyPR;

use App\Models\MyPRMessage;

interface MyPRMessageRepositoryInterface
{
    /**
     * saveChat
     * @param int $MyAIId
     * @param string $message
     * @param string $response
     * @return MyPRMessage
     */
    public function saveChat(int $myAIId, string $message, string $response): MyPRMessage;

    /**
     * getChets
     * @param int $MyAIId
     */
    public function getChets(int $MyAIId);
}
