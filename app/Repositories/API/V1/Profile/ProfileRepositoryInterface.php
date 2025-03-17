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

    /**
     * updateAddress
     * @param int $userId
     * @param string $address
     * @return void
     */
    public function updateAddress(int $userId, string $address);
}
