<?php

namespace App\Repositories\API\V1\AI\MyPR;

use App\Models\MyPR;
use Exception;
use Illuminate\Support\Facades\Log;

class MyPRRepository implements MyPRRepositoryInterface
{
    /**
     * createChat
     * @param int $user_id
     * @param string $name
     * @return MyPR
     */
    public function createChat(int $user_id, string $name): MyPR
    {
        try {
            return MyPR::create([
                'user_id' => $user_id,
                'name' => $name,
            ]);
        } catch (Exception $e) {
            Log::error('App\Repositories\API\V1\AI\MyPR\MyPRRepository::createChat', ['error' => $e->getMessage()]);
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
            return MyPR::whereUserId($user_id)->latest()->get();
        } catch (Exception $e) {
            Log::error('App\Repositories\API\V1\AI\MyPR\MyPRRepository::getChats', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
