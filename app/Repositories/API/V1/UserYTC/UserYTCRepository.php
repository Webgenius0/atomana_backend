<?php

namespace App\Repositories\API\V1\UserYTC;

use App\Models\UserYTCView;
use Exception;
use Illuminate\Support\Facades\Log;

class UserYTCRepository implements UserYTCRepositoryInterface
{
    /**
     * userYtc of the user.
     * @param int $userId
     * @return UserYTCView|null
     */
    public function userYtc(int $userId): UserYTCView|null
    {
        try {
            return UserYTCView::where("user_id", $userId)->first();
        } catch (Exception $e) {
            Log::error('App\Repositories\API\V1\UserYTC\UserYTCRepository::userYtc', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
