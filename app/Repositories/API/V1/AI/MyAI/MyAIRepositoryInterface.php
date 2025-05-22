<?php

namespace App\Repositories\API\V1\AI\MyAI;

use App\Models\MyAI;
use App\Models\User;

interface MyAIRepositoryInterface
{
    /**
     * createChat
     * @param int $user_id
     * @param string $name
     * @return \App\Models\MyAI
     */
    public function createChat(int $user_id, string $name);

    /**
     * getMessage
     * @param int $user_id
     */
    public function getChats(int $user_id);


     public function getMyAI(int $userId): MyAI;
    public function buildUserContext(User $user): string;
    public function saveChatMessage(int $myAIId, string $question, string $response): void;
}
