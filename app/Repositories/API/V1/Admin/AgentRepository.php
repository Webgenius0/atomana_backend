<?php

namespace App\Repositories\API\V1\Admin;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class AgentRepository implements AgentRepositoryInterface
{
    public function fetchAgentsOfAdmin(int $businessId, int $perPage = 10)
    {
        try {
            $data = User::select('first_name', 'last_name', 'avatar', 'email')
                ->where('role_id', 3)
                ->with([
                    'role',
                    'businesses',
                    'profile'
                ])
                ->whereHas('businesses', function ($query) use ($businessId) {
                    $query->where('businesses.id', $businessId);
                })
                ->paginate($perPage);

            return $data;
        } catch (Exception $e) {
            Log::error('AgentRepository::fetchAgentsOfAdmin', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
