<?php

namespace App\Repositories\API\V1\AgentEarning;

use Exception;
use Illuminate\Support\Facades\Log;

class AgentEarningRepository implements AgentEarningRepositoryInterface
{
    public function getAgentsOfBusiness(int $businessId)
    {
        try {
            
        }catch (Exception $e){
            Log::error('App\Repositories\API\V1\AI\AgentEarning\AgentEarningRepository::getAgentsOfBusiness', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
