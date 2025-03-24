<?php

namespace App\Repositories\API\V1\AgentEarning;

use Illuminate\Pagination\LengthAwarePaginator;

interface AgentEarningRepositoryInterface
{
    /**
     * Summary of getAgentsOfBusiness
     * @param int $businessId
     * @param int $per_page
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAgentsOfBusiness(int $businessId, int $per_page): LengthAwarePaginator;
}
