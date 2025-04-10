<?php

namespace App\Http\Resources\API\V1\Property\AccessInstruction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = parent::toArray($request);
        $data = [];

        foreach ($response['data'] as $key => $value) {
            $data [] = [
                'id' => $value['access_instruction']['id'],
                'address' => $value['address'],
            ];
        }
        $response['data'] = $data;

        return $response;
    }
}
