<?php

namespace App\Http\Resources\API\V1\Property;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreatePropertyResource extends JsonResource
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
            'id'                 => $data['id'],
            'sku'                => $data['sku'],
            'business_id'        => $data['business_id'],
            'agent'              => $data['agent'],
            'email'              => $data['email'],
            'address'            => $data['address'],
            'price'              => $data['price'],
            'expiration_date'    => $data['expiration_date'],
            'is_development'     => $data['is_development'],
            'add_to_website'     => $data['add_to_website'],
            'commission_rate'    => $data['commission_rate'],
            'is_co_listing'      => $data['is_co_listing'],
            'co_agent'           => $data['co_agent'],
            'co_list_percentage' => $data['co_list_percentage'],
            'property_source_id' => $data['property_source_id'],
            'beds'               => $data['beds'],
            'full_baths'         => $data['full_baths'],
            'half_baths'         => $data['half_baths'],
            'size'               => $data['size'],
            'link'               => $data['link'],
            'note'               => $data['note'],
        ];
    }
}
