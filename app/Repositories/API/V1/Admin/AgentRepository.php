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
            $data = User::select('id', 'first_name', 'last_name', 'handle', 'avatar', 'email', 'role_id')
                ->where('role_id', 3)
                ->with([
                    'role',
                    'businesses',
                    'profile:id,user_id,phone'
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

    /**
     * getAgentProfileById
     * @param int $userId
     * @return User
     */
    public function getAgentProfileById(int $userId)
    {
        try {
            return User::with('profile')->findOrFail($userId);
        }catch(Exception $e) {
            Log::error('AgentRepository::getAgentProfileById', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateAgentProfileById
     * @param array $credentials
     * @param int $userId
     * @return void
     */
    public function updateAgentProfileById(array $credentials, int $userId)
    {
        try {
            User::findOrFail($userId)->update($credentials);
        }catch(Exception $e) {
            Log::error('AgentRepository::updateAgentProfileById', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
