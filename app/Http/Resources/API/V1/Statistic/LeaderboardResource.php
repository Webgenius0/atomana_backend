<?php

namespace App\Http\Resources\API\V1\Statistic;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class LeaderboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $values = parent::toArray($request);
        $data = [];

        foreach ($values['list'] as $key => $value) {
            $data[] = [
                'index' => (int) $key + 1,
                'user_id' => $value['user_id'] ?? null,
                'handle' => $value['user']['handle'] ?? null,
                'name' => $value['user']['first_name'] . ' ' . $value['user']['last_name'],
                'avg_purchase_price' => $value['avg_purchase_price'] ?? null,
                'total_sales' => (int) $value['total_sales'] ?? null,
            ];
        }
        return ['total_sales' => $values['total_sales'], 'list' => $data];
    }
}
