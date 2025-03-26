<?php

namespace App\Http\Resources\API\V1\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class AgentIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $datas = parent::toArray($request);
        $agents = [];
        foreach($datas['data'] as $data) {
            $agents[] = [
                'id' => $data['id'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'handle' => $data['handle'],
                'email' => $data['email'],
                'avatar' => $data['avatar'],
                'phone' => $data['profile']['phone'],
                'role' => $data['role']['name'],
            ];
        }
        $datas['data'] = $agents;
        return $datas;
    }
}
