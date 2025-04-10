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
            'property_id' => $data['property']['id'] ?? 'N/A',
            'access_interface_id' => $data['id'] ?? 'N/A',
            'property_type_name' => $data['property_type']['name'] ?? 'N/A',
            'address' => $data['property']['address'] ?? 'N/A',
            'email' => $data['property']['email'] ?? 'N/A',
            'price' => $data['property']['price'] ?? 'N/A',
            'expiration_date' => $data['property']['expiration_date'] ?? 'N/A',
            'is_development' => $data['property']['is_development'] ?? 'N/A',
            'add_to_website' => $data['property']['add_to_website'] ?? 'N/A',
            'is_co_listing' => $data['property']['is_co_listing'] ?? 'N/A',
            'commission_rate' => $data['property']['commission_rate'] ?? 'N/A',
            'co_list_percentage' => $data['property']['co_list_percentage'] ?? 'N/A',
            'source' => $data['property']['source']['name'] ?? 'N/A',
            'agent' => ($data['property']['agent']['first_name'] ?? '') . ' ' . ($data['property']['agent']['last_name'] ?? ''),
            'co_agent' => ($data['property']['co_agent']['first_name'] ?? null) && ($data['property']['co_agent']['last_name'] ?? null)
                ? $data['property']['co_agent']['first_name'] . ' ' . $data['property']['co_agent']['last_name']
                : 'N/A',
            'size' => $data['size'] ?? 'N/A',
            'access_key' => $data['access_key'] ?? 'N/A',
            'lock_box_location' => $data['lock_box_location'] ?? 'N/A',
            'pickup_instructions' => $data['pickup_instructions'] ?? 'N/A',
            'gate_code' => $data['gate_code'] ?? 'N/A',
            'gete_access_location' => $data['gete_access_location'] ?? 'N/A',
            'visitor_parking' => $data['visitor_parking'] ?? 'N/A',
            'note' => $data['note'] ?? 'N/A',
        ];
    }
}
