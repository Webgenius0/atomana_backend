<?php

namespace App\Http\Resources\API\V1\Contract;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
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
            'id'                   => $data['id'],
            'uid'                  => $data['uid'],
            'business_id'          => $data['business_id'],
            'agent'                => $data['agent'],
            'address'              => $data['address'],
            'closing_data'         => $data['closing_data'],
            'is_co_listing'        => $data['is_co_listing'],
            'co_agent'             => $data['co_agent'],
            'represent'            => $data['represent'],
            'date_listed'          => $data['date_listed'],
            'price'                => $data['price'],
            'contract_data'        => $data['contract_data'],
            'commision_percentage' => $data['commision_percentage'],
            'co_agent_percentage'  => $data['co_agent_percentage'],
            'referral_percentage'  => $data['referral_percentage'],
            'property_source_id'   => $data['property_source_id'],
            'name'                 => $data['name'],
            'company'              => $data['company'],
            'email'                => $data['email'],
            'phone'                => $data['phone'],
            'comment'              => $data['comment'],
        ];
    }
}
