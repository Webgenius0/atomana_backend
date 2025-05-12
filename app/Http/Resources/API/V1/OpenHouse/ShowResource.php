<?php

namespace App\Http\Resources\API\V1\OpenHouse;

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
            'id' => $data['id'],
            'agent' => $data['user']['first_name']. ' '. $data['user']['last_name'],
            'sku' => $data['property']['sku'],
            'address' => $data['property']['address'],
            'price' => $data['property']['price'],
            'expiration_date' => $data['property']['expiration_date'],
            'co_agent' => ($data['property']['co_agent']['first_name'] ?? null) && ($data['property']['co_agent']['last_name'] ?? null)
            ? $data['property']['co_agent']['first_name'] . ' ' . $data['property']['co_agent']['last_name']
            : 'N/A',
            'date' => $data['date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'sign_number' => $data['sign_number']
        ];
    }
}
