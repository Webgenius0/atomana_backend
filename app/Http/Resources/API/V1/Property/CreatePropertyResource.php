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
            'id' => $data['id'],
            'business_id' => $data['business_id'],
            'user_id' => $data['user_id'],
            'email' => $data['email'],
            'address' => $data['address'],
            'price' => $data['price'],
            'expiration_date' => $data['expiration_date'],
            'development' => $data['development'],
            'co_listing' => $data['co_listing'],
            'source' => $data['source'],
        ];
    }
}
