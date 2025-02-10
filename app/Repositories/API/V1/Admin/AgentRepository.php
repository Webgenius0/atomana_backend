<?php

namespace App\Repositories\API\V1\Admin;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class AgentRepository implements AgentRepositoryInterface
{
    public function fetchAgentsOfAdmin(int $userId, int $perPage = 10)
    {
        try {
            
        }catch (Exception $e) {
            Log::error('AgentRepository::fetchAgentsOfAdmin', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
