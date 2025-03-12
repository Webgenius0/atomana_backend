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
            'business_id'        => $data['business_id'],
            'agent'              => $data['agent'],
            'email'              => $data['email'],
            'address'            => $data['address'],
            'price'              => $data['price'],
            'expiration_date'    => $data['expiration_date'],
            'is_development'     => $data['is_development'],
            'add_to_website'     => $data['add_to_website'],
            'is_co_listing'      => $data['is_co_listing'],
            'co_agent'           => $data['co_agent'],
            'co_list_percentage' => $data['co_list_percentage'],
            'source'             => $data['source'],
        ];
    }
}
