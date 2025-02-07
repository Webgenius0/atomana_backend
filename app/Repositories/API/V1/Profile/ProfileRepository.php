<?php

namespace App\Repositories\API\V1\Profile;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class ProfileRepository implements ProfileRepositoryInterface
{
    /**
     * geth the profile info a admin user
     *
     * @param int $userId
     * @return User
     */
    public function getAdminProfileData(int $userId): User
    {
        try {
            $user = User::with([
                'profile',
                'role',
                'businesses' => function ($query) {
                    $query->limit(1);
                },
            ])->findOrFail($userId);
            return $user;
        } catch (Exception $e) {
            Log::error('ProfileRepository::getProfileData', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    /**
     * geth the profile info a agent user
     *
     * @param int $userId
     * @return User
     */
    public function getAgentProfileData(int $userId): User
    {
        try {
            $user = User::with(['profile', 'role'])->findOrFail($userId);
            return $user;
        } catch (Exception $e) {
            Log::error('ProfileRepository::getProfileData', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
