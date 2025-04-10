<?php

namespace App\Http\Resources\API\V1\Property\AccessInstruction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowResource extends JsonResource
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
            'property_id' => $data['property']['id'],
            'access_interface_id' => $data['id'],
            'property_type_name' => $data['property_type']['name'],
            'address' => $data['property']['address'],
            'email' => $data['property']['email'],
            'price' => $data['property']['price'],
            'expiration_date' => $data['property']['expiration_date'],
            'is_development' => $data['property']['is_development'],
            'add_to_website' => $data['property']['add_to_website'],
            'is_co_listing' => $data['property']['is_co_listing'],
            'commission_rate' => $data['property']['commission_rate'],
            'co_list_percentage' => $data['property']['co_list_percentage'],
            'source' => $data['property']['source']['name'],
            'agent' => $data['property']['agent']['first_name']. ' '. $data['property']['agent']['last_name'],
            'co_agent' => $data['property']['co_agent']['first_name']. ' '. $data['property']['agent']['last_name'],
            'size' => $data['size'],
            'access_key' => $data['access_key'],
            'lock_box_location' => $data['lock_box_location'],
            'pickup_instructions' => $data['pickup_instructions'],
            'gate_code' => $data['gate_code'],
            'gete_access_location' => $data['gete_access_location'],
            'visitor_parking' => $data['visitor_parking'],
            'note' => $data['note'],
        ];
    }
}
