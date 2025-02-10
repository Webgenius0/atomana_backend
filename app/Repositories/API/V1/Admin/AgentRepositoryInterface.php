<?php

namespace App\Repositories\API\V1\Admin;

interface AgentRepositoryInterface
{
    public function fetchAgentsOfAdmin(int $businessId, int $perPage = 10);
}
