<?php

namespace App\Repositories\API\V1\User;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserRepositoryInterface
{
    /**
     * get Name And Id
     * @param int $userId
     */
    public function getNameAndId(int $userId)
    {
        try {
            return User::select('id', 'first_name', 'last_name', 'handle')->whereId($userId)->get();
        } catch (Exception $e) {
            Log::error('UserRepository::selfInfo', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * return agents of same business
     * @param mixed $businessId
     */
    public function getAgentsNameAndId($businessId)
    {
        try {
            return User::select('id', 'first_name', 'last_name', 'handle')
                ->wherehas('businesses', function ($query) use ($businessId) {
                    $query->where('businesses.id', $businessId);
                })->whereRoleId(3)->get();
        } catch (Exception $e) {
            Log::error('UserRepository::allAgents', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function agentData($userId): array
    {
        try {
            return ['agent user id' => $userId];
        } catch (Exception $e) {
            Log::error('UserRepository::agentData', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function businessData($userId): array
    {
        try {
            return ['business user id' => $userId];
        } catch (Exception $e) {
            Log::error('UserRepository::businessData', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    public function fetchTopAgents(string $sortedBy, string $filter)
    {
        try {
            return User::whereRoleId(2);
        } catch (Exception $e) {
            Log::error('UserRepository::fetchTopAgents', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
