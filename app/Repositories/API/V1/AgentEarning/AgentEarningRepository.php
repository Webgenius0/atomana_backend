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
     * @return LengthAwarePaginator
     */
    public function getAgentsOfBusiness(int $businessId, int $per_page): LengthAwarePaginator
    {
        try {
            return AgentEarningView::select([
                'user_id',
                'sales_closed',
                'dollars_on_closed_deals_ytd',
                'current_year_start',
                'percentage_total_dollars_on_close_deal',
                'gross_commission_income_ytd',
                'brokerage_cut_ytd',
                'net_commission_ytd',
                'agent_net_income_ytd',
                'group_gross_income_ytd',
                'group_net_ytd',
                'percentage_group_gross_income_ytd'
            ])->where('business_id', $businessId)->with(['user:id,first_name,last_name,handle'])->paginate($per_page);
        } catch (Exception $e) {
            Log::error('App\Repositories\API\V1\AI\AgentEarning\AgentEarningRepository::getAgentsOfBusiness', ['error' => $e->getMessage()]);
            throw $e;
        }
    }



    public function getAgentsOfBusinessBySearch(int $businessId, int $per_page): LengthAwarePaginator
    {
        try {
            return AgentEarningView::select([
                'user_id',
                'sales_closed',
                'dollars_on_closed_deals_ytd',
                'current_year_start',
                'percentage_total_dollars_on_close_deal',
                'gross_commission_income_ytd',
                'brokerage_cut_ytd',
                'net_commission_ytd',
                'agent_net_income_ytd',
                'group_gross_income_ytd',
                'group_net_ytd',
                'percentage_group_gross_income_ytd'
            ])->where('business_id', $businessId)->with(['user:id,first_name,last_name,handle'])->paginate($per_page);
        } catch (Exception $e) {
            Log::error('App\Repositories\API\V1\AI\AgentEarning\AgentEarningRepository::getAgentsOfBusiness', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
