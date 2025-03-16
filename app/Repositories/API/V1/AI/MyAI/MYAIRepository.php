<?php

namespace App\Repositories\API\V1\AI\MyAI;

use App\Models\MyAI;
use Exception;
use Illuminate\Support\Facades\Log;

class MyAIRepository implements MyAIRepositoryInterface
{
    /**
     * createChat
     * @param int $user_id
     * @param string $name
     * @return MyAI
     */
    public function createChat(int $user_id, string $name)
    {
        try {
            return MyAI::create([
                'user_id' => $user_id,
                'name' => $name,
            ]);
        } catch (Exception $e) {
            Log::error('App\Repositories\API\V1\AI\MyAI\MYAIRepository::createChat', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * getChats
     * @param int $user_id
     */
    public function getChats(int $user_id)
    {
        try {
            return MyAI::whereUserId($user_id)->get();
        } catch (Exception $e) {
            Log::error('App\Repositories\API\V1\AI\MyAI\MYAIRepository::getChats', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
