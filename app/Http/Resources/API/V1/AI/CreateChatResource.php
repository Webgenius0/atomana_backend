<?php

namespace App\Http\Resources\API\V1\AI;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreateChatResource extends JsonResource
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
            'my_a_i_id' => $data['my_a_i_id'],
            'message' => $data['message'],
            'response' => $data['response'],
        ];
    }
}
