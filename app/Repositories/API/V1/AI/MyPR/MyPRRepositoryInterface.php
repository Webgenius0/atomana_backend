<?php

namespace App\Repositories\API\V1\AI\MyPR;

use App\Models\MyPR;

interface MyPRRepositoryInterface
{
    /**
     * createChat
     * @param int $user_id
     * @param string $name
     * @return MyPR
     */
    public function createChat(int $user_id, string $name): MyPR;


    /**
     * getChats
     * @param int $user_id
     */
    public function getChats(int $user_id);
}
