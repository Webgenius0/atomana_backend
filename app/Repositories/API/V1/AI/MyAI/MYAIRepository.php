<?php

namespace App\Repositories\API\V1\AI\MyAI;

use App\Models\MyAI;
use Exception;
use Illuminate\Support\Facades\Log;

class MYAIRepository implements MYAIRepositoryInterface
{
    /**
     * createMessage
     * @param int $user_id
     * @param array $credentials
     * @return MyAI
     */
    public function createMessage(int $user_id, array $credentials)
    {
        try {
            return MyAI::create([
                'user_id' => $user_id,
                'name' => $credentials['name'],
            ]);
        } catch (Exception $e) {
            Log::error('App\Repositories\API\V1\AI\MyAI\MYAIRepository::createMessage', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * getMessage
     * @param int $user_id
     */
    public function getMessage(int $user_id)
    {
        try {
            return MyAI::whereUserId($user_id)->get();
        } catch (Exception $e) {
            Log::error('App\Repositories\API\V1\AI\MyAI\MYAIRepository::getMessage', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
