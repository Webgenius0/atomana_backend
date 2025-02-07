<?php

namespace App\Repositories\API\V1\Profile;

use App\Models\User;

interface ProfileRepositoryInterface
{
    /**
     * geth the profile info a business user
     *
     * @param int $userId
     * @return User
     */
    public function getAdminProfileData(int $userId);

    /**
     * geth the profile info a agent user
     *
     * @param int $userId
     * @return User
     */
    public function getAgentProfileData(int $userId);
}
