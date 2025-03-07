<?php

namespace App\Http\Resources\API\V1\SalesTrack;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexSalesTrackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $datas = parent::toArray($request);

        $response = [];

        foreach ($datas['data'] as $data) {
            $response[] = [
                'id'                  => $data['id'],
                'user_id'             => $data['user_id'],
                'business_id'         => $data['business_id'],
                'property_id'         => $data['property_id'],
                'user_first_name'     => $data['user_first_name'],
                'user_last_name'      => $data['user_last_name'],
                'address'             => $data['address'],
                'created_at'          => $data['created_at'],
                'price'               => $data['price'],
                'expiration_date'     => $data['expiration_date'],
                'co_agent_first_name' => $data['co_agent_first_name'],
                'co_agent_last_name'  => $data['co_agent_last_name'],
                'co_list_percentage'  => $data['co_list_percentage'],
                'status'              => $data['status'],
                'date_under_contract' => $data['date_under_contract'],
                'closing_date'        => $data['closing_date'],
                'purchase_price'      => $data['purchase_price'],
                'buyer_seller'        => $data['buyer_seller'],
                'referral_fee_pct'    => $data['referral_fee_pct'],
                'note'                => $data['note'],
            ];
        }

        return $response;
    }
}
