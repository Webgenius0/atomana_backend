<?php

namespace App\Repositories\API\V1\AgentEarning;

use App\Models\AgentEarningView;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class AgentEarningRepository implements AgentEarningRepositoryInterface
{
    /**
     * Summary of getAgentsOfBusiness
     * @param int $businessId
     * @param int $per_page
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAgentsOfBusiness(int $businessId, int $per_page): LengthAwarePaginator
    {
        try {
            return AgentEarningView::where('business_id', $businessId)->paginate($per_page);
        } catch (Exception $e) {
            Log::error('App\Repositories\API\V1\AI\AgentEarning\AgentEarningRepository::getAgentsOfBusiness', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
