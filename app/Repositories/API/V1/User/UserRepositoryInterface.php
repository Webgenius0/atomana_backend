<?php

namespace App\Repositories\API\V1\User;

interface UserRepositoryInterface
{
    /**
     * get Name And Id
     * @param int $userId
     */
    public function getNameAndId(int $userId);

    /**
     * return agents of same business
     * @param mixed $businessId
     */
    public function getAgentsNameAndId(int $businessId);
}
