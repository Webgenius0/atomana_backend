<?php

namespace App\Services\API\V1\User;

use App\Repositories\API\V1\User\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AgentService
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
     * get agent name and id for dropdown
     */
    public function getAgentsDropdown()
    {
        try {
            $role = $this->user->role->slug;
            $agents = null;
            if ($role == 'agent'){
                $agents = $this->userRepository->getNameAndId($this->user->id);
            } else {
                $agents = $this->userRepository->getAgentsNameAndId($this->user->business()->id);
            }
            return $agents;
        }catch(Exception $e) {
            Log::error('AgentService::getAgents', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
