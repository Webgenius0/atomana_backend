<?php

namespace App\Http\Resources\API\V1\Target;

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

        return  [
            'id' => $data['id'],
            'user_id' => $data['user_id'],
            'month' => $data['month'],
            'amount' => $data['amount'],
            'for' => $data['for'],
        ];
    }
}
