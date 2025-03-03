<?php

namespace App\Http\Resources\API\V1\OpenHouse;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreateResource extends JsonResource
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
            'business_id' => $data['business_id'],
            'property_id' => $data['property_id'],
            'date' => $data['date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'wavy_man' => $data['wavy_man'],
            'sign_number' => $data['sign_number'],
        ];
    }
}
