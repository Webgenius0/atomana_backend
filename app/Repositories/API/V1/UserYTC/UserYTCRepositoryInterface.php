<?php

namespace App\Repositories\API\V1\UserYTC;

use App\Models\UserYTCView;

interface UserYTCRepositoryInterface
{
    /**
     * userYtc of the user.
     * @param int $userId
     * @return \App\Models\UserYTCView|null
     */
    public function userYtc(int $userId): UserYTCView|null;
}
