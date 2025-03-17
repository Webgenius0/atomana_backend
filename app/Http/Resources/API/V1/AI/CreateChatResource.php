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
            'id' => $data[0]['id'],
            'user_id' => $data[0]['user_id'],
            'name' => $data[0]['name'],
            'chat_id' => $data[1]['id'],
            'message' => $data[1]['message'],
            'response' => $data[1]['response'],
        ];
    }
}
