<?php

namespace App\Http\Resources\API\V1\Expense\SubCategory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class ExpenseSubCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $datas =  parent::toArray($request);
        $response = [];
        foreach($datas as $data)
        {
            $tempData = [
                'id' => $data['id'],
                'name' => $data['name'],
            ];

            $response[] = $tempData;
        }
        return $response;
    }
}
