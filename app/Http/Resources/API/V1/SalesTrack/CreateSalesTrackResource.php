<?php

namespace App\Http\Resources\API\V1\SalesTrack;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreateSalesTrackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);

        return [
            'id' => $data['id'],
            'track_id' => $data['track_id'],
            'user_id' => $data['user_id'],
            'business_id' => $data['business_id'],
            'property_id' => $data['property_id'],
            'status' => $data['status'],
            'date_under_contract' => $data['date_under_contract'],
            'closing_date' => $data['closing_date'],
            'purchase_price' => $data['purchase_price'],
            'buyer_seller' => $data['buyer_seller'],
            'referral_fee_pct' => $data['referral_fee_pct'],
            'commission_on_sale' => $data['commission_on_sale'],
            'note' => $data['note'],
        ];
    }
}
