<?php

namespace App\Repositories\API\V1\Profile;

use App\Models\Profile;
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

    /**
     * updateAddress
     * @param int $userId
     * @param string $address
     * @return void
     */
    public function updateAddress(int $userId, string $address)
    {
        try {
            $profile = Profile::whereUserId($userId)->first();
            $profile->address = $address;
            $profile->save();
        }catch (Exception $e) {
            Log::error('ProfileRepository::updateAddress', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateSocialMedia
     * @param int $userId
     * @param array $credentials
     * @return void
     */
    public function updateSocialMedia(int $userId, array $credentials)
    {
        try {
            $profile = Profile::whereUserId($userId)->first();
            $profile->facebook = $credentials['facebook'];
            $profile->instagram = $credentials['instagram'];
            $profile->twitter = $credentials['twitter'];
            $profile->save();
        }catch (Exception $e) {
            Log::error('ProfileRepository::updateSocialMedia', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateBirthDay
     * @param int $userId
     * @param string $date
     * @return void
     */
    public function updateBirthDay(int $userId, string $date)
    {
        try {
            $profile = Profile::whereUserId($userId)->first();
            $profile->date_of_birth = $date;
            $profile->save();
        }catch (Exception $e) {
            Log::error('ProfileRepository::updateBirthDay', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateSpearsGroupAnniversaryHomeAddress
     * @param int $userId
     * @param string $address
     * @return void
     */
    public function updateSpearsGroupAnniversaryHomeAddress(int $userId, string $address)
    {
        try {
            $profile = Profile::whereUserId($userId)->first();
            $profile->spears_group_anniversary_home_address = $address;
            $profile->save();
        }catch (Exception $e) {
            Log::error('ProfileRepository::updateSpearsGroupAnniversaryHomeAddress', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updatePhone
     * @param int $userId
     * @param string $phone
     * @return void
     */
    public function updatePhone(int $userId, string $phone)
    {
        try {
            $profile = Profile::whereUserId($userId)->first();
            $profile->phone = $phone;
            $profile->save();
        }catch (Exception $e) {
            Log::error('ProfileRepository::updatePhone', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

}
