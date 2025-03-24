<?php

namespace App\Repositories\API\V1\AgentEarning;

interface AgentEarningRepositoryInterface
{
    public function getAgentsOfBusiness(int $businessId);
}
