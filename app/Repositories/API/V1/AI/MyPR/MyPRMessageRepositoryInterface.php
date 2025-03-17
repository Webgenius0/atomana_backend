<?php

namespace App\Repositories\API\V1\AI\MyPR;

use App\Models\MyPRMessage;

interface MyPRMessageRepositoryInterface
{
    /**
     * saveChat
     * @param int $myPRId
     * @param string $message
     * @param string $response
     * @return MyPRMessage
     */
    public function saveChat(int $myPRId, string $message, string $response): MyPRMessage;

    /**
     * getChets
     * @param int $myPRId
     */
    public function getChets(int $myPRId);
}
