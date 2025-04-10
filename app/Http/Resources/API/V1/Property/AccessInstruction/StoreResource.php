<?php

namespace App\Http\Resources\API\V1\Property\AccessInstruction;

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
        $response = parent::toArray($request);

        return [
            "id"                   => $response["id"],
            "property_type_id"    => $response["property_type_id"],
            "size"                 => $response["size"],
            "access_key"           => $response["access_key"],
            "lock_box_location"    => $response["lock_box_location"],
            "pickup_instructions"  => $response["pickup_instructions"],
            "gate_code"            => $response["gate_code"],
            "gete_access_location" => $response["gete_access_location"],
            "visitor_parking"      => $response["visitor_parking"],
            "note"                 => $response["note"],
        ];
    }
}
