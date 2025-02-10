<?php

namespace App\Repositories\API\V1\Admin;

interface AgentRepositoryInterface
{
    public function fetchAgentsOfAdmin(int $userId, int $perPage = 10);
}
