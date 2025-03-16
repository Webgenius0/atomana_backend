<?php

namespace App\Repositories\API\V1\AI\MyAI;

interface MYAIMessageRepositoryInterface
{
    /**
     * saveChat
     * @param int $MyAIId
     * @param string $message
     * @param string $response
     * @return \App\Models\MyAIMessage
     */
    public function saveChat(int $MyAIId, string $message, string $response);

    /**
     * getChets
     * @param int $MyAIId
     */
    public function getChets(int $MyAIId);
}
