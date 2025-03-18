<?php

namespace App\Services\API\V1\Profile;

use App\Repositories\API\V1\Profile\ProfileRepositoryInterface;
use Carbon\Carbon;
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
     * addressUpdateOperation
     * @param mixed $address
     * @return void
     */
    public function addressUpdateOperation(string $address)
    {
        try {
            $this->profileRepository->updateAddress($this->user->id, $address);
        }catch (Exception $e) {
            Log::error('ProfileService::addressUpdateOperation', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    public function phoneUpdateOperation(string $phone)
    {
        try {
            $this->profileRepository->updatePhone($this->user->id, $phone);
        }catch (Exception $e) {
            Log::error('ProfileService::phoneUpdateOperation', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * birthdayUpdateOperation
     * @param string $date
     * @return void
     */
    public function birthdayUpdateOperation(string $date)
    {
        try {
            $formattedDate = Carbon::createFromFormat('m-d-Y', $date)->toDateString();
            $this->profileRepository->updateBirthDay($this->user->id, $formattedDate);
        }catch (Exception $e) {
            Log::error('ProfileService::birthdayUpdateOperation', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * anniversaryHomeAddrressUpdateOperation
     * @param string $address
     * @return void
     */
    public function anniversaryHomeAddrressUpdateOperation(string $address)
    {
        try {
            $this->profileRepository->updateSpearsGroupAnniversaryHomeAddress($this->user->id, $address);
        }catch (Exception $e) {
            Log::error('ProfileService::anniversaryHomeAddrressUpdateOperation', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * socialMediaUpdateOperation
     * @param array $credentials
     * @return void
     */
    public function socialMediaUpdateOperation(array $credentials)
    {
        try {
            $this->profileRepository->updateSocialMedia($this->user->id, $credentials);
        }catch (Exception $e) {
            Log::error('ProfileService::socialMediaUpdateOperation', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * aboutUpdateOperation
     * @param string $bio
     * @return void
     */
    public function aboutUpdateOperation(string $bio)
    {
        try {
            $this->profileRepository->updateBio($this->user->id, $bio);
        }catch (Exception $e) {
            Log::error('ProfileService::aboutUpdateOperation', ['error' => $e->getMessage()]);
            throw $e;
        }
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
