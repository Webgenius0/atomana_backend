<?php

namespace App\Http\Resources\API\V1\SalesTrack;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexSalesTrackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $datas = parent::toArray($request);

        $response = [];

        foreach($datas['data'] as $data) {
            $response[] = [
                'id' => $data['id'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'address' => $data['address'],
                'price' => $data['price'],
                'status' => $data['status'],
                'expiration_date' => $data['expiration_date'],
                'note' => $data['note'],
            ];
        }

        return $response;
    }
}
