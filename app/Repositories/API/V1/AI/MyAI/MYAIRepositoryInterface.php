<?php

namespace App\Repositories\API\V1\AI\MyAI;

interface MyAIRepositoryInterface
{
    /**
     * createMessage
     * @param int $user_id
     * @param string $name
     * @return \App\Models\MyAI
     */
    public function createMessage(int $user_id, string $name);

    /**
     * getMessage
     * @param int $user_id
     */
    public function getMessage(int $user_id);
}
