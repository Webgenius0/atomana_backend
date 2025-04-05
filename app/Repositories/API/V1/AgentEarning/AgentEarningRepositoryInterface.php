<?php

namespace App\Repositories\API\V1\AgentEarning;

use Illuminate\Pagination\LengthAwarePaginator;

interface AgentEarningRepositoryInterface
{
    /**
     * Summary of getAgentsOfBusiness
     * @param int $businessId
     * @param int $per_page
     * @return LengthAwarePaginator
     */
    public function getAgentsOfBusiness(int $businessId, int $per_page): LengthAwarePaginator;


    /**
     * Summary of getAgentsOfBusiness
     * @param int $businessId
     * @param int $per_page
     * @return LengthAwarePaginator
     */
    public function getAgentsOfBusinessBySearch(int $businessId, int $per_page): LengthAwarePaginator;
}
