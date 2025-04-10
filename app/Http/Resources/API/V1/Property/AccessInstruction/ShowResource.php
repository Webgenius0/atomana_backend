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

        // return $data;

        return [
            'property_id' => $data['property']['id'] ?? null,
            'access_interface_id' => $data['id'] ?? null,
            'property_type_name' => $data['property_type']['name'] ?? null,
            'address' => $data['property']['address'] ?? null,
            'email' => $data['property']['email'] ?? null,
            'price' => $data['property']['price'] ?? null,
            'expiration_date' => $data['property']['expiration_date'] ?? null,
            'is_development' => $data['property']['is_development'] ?? null,
            'add_to_website' => $data['property']['add_to_website'] ?? null,
            'is_co_listing' => $data['property']['is_co_listing'] ?? null,
            'commission_rate' => $data['property']['commission_rate'] ?? null,
            'co_list_percentage' => $data['property']['co_list_percentage'] ?? null,
            'source' => $data['property']['source']['name'] ?? null,
            'agent' => ($data['property']['agent']['first_name'] ?? '') . ' ' . ($data['property']['agent']['last_name'] ?? ''),
            'co_agent' => ($data['property']['co_agent']['first_name'] ?? null) && ($data['property']['co_agent']['last_name'] ?? null)
                ? $data['property']['co_agent']['first_name'] . ' ' . $data['property']['co_agent']['last_name']
                : 'N/A',
            'size' => $data['size'] ?? null,
            'access_key' => $data['access_key'] ?? null,
            'lock_box_location' => $data['lock_box_location'] ?? null,
            'pickup_instructions' => $data['pickup_instructions'] ?? null,
            'gate_code' => $data['gate_code'] ?? null,
            'gete_access_location' => $data['gete_access_location'] ?? null,
            'visitor_parking' => $data['visitor_parking'] ?? null,
            'note' => $data['note'] ?? null,
        ];
    }
}
