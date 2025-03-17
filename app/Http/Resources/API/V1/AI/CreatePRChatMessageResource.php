<?php

namespace App\Http\Resources\API\V1\AI;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreatePRChatMessageResource extends JsonResource
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
            'my_p_r_id' => $data['my_p_r_id'],
            'message' => $data['message'],
            'response' => $data['response'],
        ];
    }
}
