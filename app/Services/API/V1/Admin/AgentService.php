<?php

namespace App\Services\API\V1\Admin;

use App\Models\User;
use App\Repositories\API\V1\Admin\AgentRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AgentService
{
    protected AgentRepositoryInterface $agentRepository;
    protected $user;

    public function __construct(AgentRepositoryInterface $agentRepository)
    {
        $this->agentRepository = $agentRepository;
        $this->user = Auth::user();
    }


    public function getAgents():mixed
    {
        try{
            $perPage = request()->query('per_page', 10);
            $business = $this->user->business();
            $data = $this->agentRepository->fetchAgentsOfAdmin($business->id, $perPage);
            return $data;
        }catch(Exception $e) {
            Log::error('App\Services\API\V1\Admin\AgentService::getAgents', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    /**
     * getAgentDetails
     * @param \App\Models\User $user
     */
    public function getAgentDetails(User $user)
    {
        try {
            return $this->agentRepository->getAgentProfileById($user->id);
        }catch(Exception $e) {
            Log::error('App\Services\API\V1\Admin\AgentService::getAgentDetails', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateAgentProfile
     * @param \App\Models\User $user
     * @param array $credentials
     * @return void
     */
    public function updateAgentProfile(User $user, array $credentials)
    {
        try {
            $this->agentRepository->updateAgentProfileById($credentials, $user->id);
        }catch(Exception $e) {
            Log::error('App\Services\API\V1\Admin\AgentService::updateAgentProfile', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


}
