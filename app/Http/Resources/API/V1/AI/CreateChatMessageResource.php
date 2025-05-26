<?php

namespace App\Http\Resources\API\V1\AI;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreateChatMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        // $data = parent::toArray($request);

        // return [
        //     'id' => $data['id'],
        //     'my_a_i_id' => $data['my_a_i_id'],
        //     'message' => $data['message'],
        //     'response' => $data['response'],
        // ];

        // If it's an array (from service), map keys manually
        if (is_array($this->resource)) {
            return [
                'id' => $this->resource['id'] ?? null,
                'my_a_i_id' => $this->resource['my_a_i_id'] ?? null,
                'message' => $this->resource['question'] ?? null,
                'response' => $this->resource['reply'] ?? null,
            ];
        }

        // If it's an Eloquent model or resource, use parent
        $data = parent::toArray($request);

        return [
            'id' => $data['id'] ?? null,
            'my_a_i_id' => $data['my_a_i_id'] ?? null,
            'message' => $data['message'] ?? null,
            'response' => $data['response'] ?? null,
        ];
    }
}
