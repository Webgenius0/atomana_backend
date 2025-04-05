<?php

namespace App\Http\Resources\API\V1\OpenHouse;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DropdownResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);

        $response = [];

        foreach($data as $key => $value) {
            $temp = [
                'id' => $value['id'],
                'address' => $value['property']['address'],
            ];

            $response[] = $temp;
        }

        return $response;
    }
}
