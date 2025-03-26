<?php

namespace App\Repositories\API\V1\Admin;

interface AgentRepositoryInterface
{
    public function fetchAgentsOfAdmin(int $businessId, int $perPage = 10);

    public function getAgentProfileById(int $userId);

    public function updateAgentProfileById(array $credentials, int $userId);

}
