<?php

namespace App\Http\Resources\API\V1\AgentEarning;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class IndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = parent::toArray($request);

        $datas = $response['data'];

        $list = [];

        foreach($datas as $data)
        {
            $list[] = [
                'user_id' => $data['user']['id'],
                'user_name' => $data['user']['first_name'] .' '. $data['user']['last_name'],
                'handle' => $data['user']['handle'],
                'sales_closed' => $data['sales_closed'],
                'dollars_on_closed_deals_ytd' => $data['dollars_on_closed_deals_ytd'],
                'current_year_start' => $data['current_year_start'],
                'percentage_total_dollars_on_close_deal' => $data['percentage_total_dollars_on_close_deal'],
                'gross_commission_income_ytd' => $data['gross_commission_income_ytd'],
                'brokerage_cut_ytd' => $data['brokerage_cut_ytd'],
                'net_commission_ytd' => $data['net_commission_ytd'],
                'agent_net_income_ytd' => $data['agent_net_income_ytd'],
                'group_gross_income_ytd' => $data['group_gross_income_ytd'],
                'group_net_ytd' => $data['group_net_ytd'],
                'percentage_group_gross_income_ytd' => $data['percentage_group_gross_income_ytd'],

            ];
        }
        $response['data'] = $list;
        return $response;
    }
}
