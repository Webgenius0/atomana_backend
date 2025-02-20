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
            'user_id' => $data['user_id'],
            'property_id' => $data['property_id'],
            'price' => $data['price'],
            'status' => $data['status'],
            'note' => $data['note'],
        ];
    }
}
