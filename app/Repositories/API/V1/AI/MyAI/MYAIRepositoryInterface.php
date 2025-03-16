<?php

namespace App\Repositories\API\V1\AI\MyAI;

interface MYAIRepositoryInterface
{
    /**
     * createMessage
     * @param int $user_id
     * @param array $credentials
     * @return \App\Models\MyAI
     */
    public function createMessage(int $user_id, array $credentials);

    /**
     * getMessage
     * @param int $user_id
     */
    public function getMessage(int $user_id);
}
