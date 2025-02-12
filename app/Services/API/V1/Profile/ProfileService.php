<?php

namespace App\Services\API\V1\Profile;

use App\Repositories\API\V1\Profile\ProfileRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileService
{
    protected ProfileRepositoryInterface $profileRepository;
    protected $user;

    /**
     * initilizing the class with Profile Repository;
     * @param \App\Repositories\API\V1\Profile\ProfileRepositoryInterface $profileRepository
    */
    public function __construct(ProfileRepositoryInterface $profileRepository)
    {
        $this->profileRepository = $profileRepository;
        $this->user = Auth::user();
    }


    /**
     * getting the profile of the user based on the rold of the user
     *
     * @return mixed
     */
    public function getProfile():mixed
    {
        try{
            $userRole = $this->user->role->slug;
            if ($userRole == 'admin') {
                $data = $this->profileRepository->getAdminProfileData($this->user->id);
            }
            else if ($userRole == 'agent') {
                $data = $this->profileRepository->getAgentProfileData($this->user->id);
            }
            return $data;
        }catch(Exception $e) {
            Log::error('ProfileService::getProfile', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
