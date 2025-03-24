<?php

namespace App\Services\API\V1\MyAgentEarning;

use App\Repositories\API\V1\AgentEarning\AgentEarningRepositoryInterface;
use App\Repositories\API\V1\SalesTrack\SalesTrackRepositoryInterface;
use App\Repositories\API\V1\UserYTC\UserYTCRepositoryInterface;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MyAgentEarningService
{
    private $businessId;
    private AgentEarningRepositoryInterface $agentEarningRepository;

    /**
     * construct
     * @param \App\Repositories\API\V1\AgentEarning\AgentEarningRepositoryInterface $agentEarningRepository
     */
    public function __construct(AgentEarningRepositoryInterface $agentEarningRepository)
    {
        $this->agentEarningRepository = $agentEarningRepository;
        $this->businessId = Auth::user()->business()->id;
    }


    /**
     * businessAgentEarning
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function businessAgentEarning(): LengthAwarePaginator
    {
        try {
            $perPage = request()->query('per_page', 25);
            return $this->agentEarningRepository->getAgentsOfBusiness($this->businessId, $perPage);
        }catch (Exception $e){
            Log::error("App\Services\API\V1\MyAgentEarning\MyAgentEarningService::getData". ['error' => $e->getMessage()]);
            throw $e;
        }
    }

}
