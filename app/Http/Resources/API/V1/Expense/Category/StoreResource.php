<?php

namespace App\Http\Resources\API\V1\Expense\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
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
            'name' => $data['name'],
            'slug' => $data['slug'],
        ];
    }
}
