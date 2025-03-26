<?php

namespace App\Http\Resources\API\V1\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgentProfileShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data =  parent::toArray($request);
        return [
            "id"=> $data['id'],
            "first_name"=> $data['first_name'],
            "last_name"=> $data['last_name'],
            "email"=> $data['email'],
            "phone"=> $data['profile']['phone'],
            "contract_year_start"=> $data['profile']['contract_year_start'],
            "total_commission_this_contract_year"=> $data['profile']['total_commission_this_contract_year'],
            "aggrement"=> $data['profile']['aggrement'],
            "file"=> $data['profile']['file'],
        ];
    }
}
