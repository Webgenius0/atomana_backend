<?php

namespace App\Services\API\V1\User;

use App\Repositories\API\V1\User\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserService
{
    protected UserRepositoryInterface $userRepository;
    protected $user;

    /**
     * construct
     * @param \App\Repositories\API\V1\User\UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->user = Auth::user();
    }


    /**
     * getting the data base on the role of the user
     * the data is for the home page of the user
     * @return array
     */
    public function data()
    {
        try {
            $user = $this->user;
            if ($user->role->name == 'amdin'){
                return $this->userRepository->businessData($user->id);
            }
            return $this->userRepository->agentData($user->id);
        } catch(Exception $e) {
            Log::error('UserService::data', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
