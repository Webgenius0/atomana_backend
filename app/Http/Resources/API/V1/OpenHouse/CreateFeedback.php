<?php

namespace App\Http\Resources\API\V1\OpenHouse;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreateFeedback extends JsonResource
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
            'id'                  => $data['id'],
            'user_id'             => $data['user_id'],
            'business_id'         => $data['business_id'],
            'property_id'         => $data['property_id'],
            'open_house_id'       => $data['open_house_id'],
            'people_count'        => $data['people_count'],
            'feedback'            => $data['feedback'],
            'additional_feedback' => $data['additional_feedback'],
        ];
    }
}
