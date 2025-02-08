<?php

namespace App\Http\Resources\API\V1\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterAgentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        $user = [
            'first_name' => $data['user']['first_name'],
            'last_name' => $data['user']['last_name'],
            'handle' => $data['user']['handle'],
            'email' => $data['user']['email'],
            'role' => $data['role']['name'],
            'phone' => $data['profile']['phone'],
            'date_of_birth' => $data['profile']['date_of_birth'],
            'address' => $data['profile']['address'],
            'bio' => $data['profile']['bio'],
        ];
        return [
            'token' => $data['token'],
            'verify' => $data['verify'],
            'user' => $user,
        ];
    }
}
