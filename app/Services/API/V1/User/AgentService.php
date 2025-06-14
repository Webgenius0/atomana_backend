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

    protected $businessId;

    /**
     * construct
     * @param \App\Repositories\API\V1\User\UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->user = Auth::user();
        $this->businessId = $this->user->business()->id;
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
                $agents = $this->userRepository->getAgentsNameAndId($this->businessId);
            }
            return $agents;
        }catch(Exception $e) {
            Log::error('AgentService::getAgents', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    /**
     * get agent name and id for dropdown
     */
    public function getAgentsCoList()
    {
        try {
            $agents = $this->userRepository->getCoListingAgents($this->user->id, $this->businessId);
            return $agents;
        }catch(Exception $e) {
            Log::error('AgentService::getAgents', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
