<?php

namespace App\Http\Resources\API\V1\Profile;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class ShowProfileResource extends JsonResource
{
        /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        try {
            $data = parent::toArray($request);
            if (isset($data['businesses'])) {
                return $this->responseForAdmin($data);
            } else {
                return $this->responseForAgent($data);
            }
        } catch (Exception $e) {
            Log::error('ShowProfileResource::toArray', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    private function responseForAdmin(array $data)
    {
        return [
            'id'            => $data['id'],
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'handle'        => $data['handle'],
            'email'         => $data['email'],
            'avatar'        => $data['avatar'],
            'role'          => $data['role']['name'],
            'status'        => $data['status'],
            'licence'       => $data['businesses'][0]['licence'],
            'ecar_id'       => $data['businesses'][0]['ecar_id'],
            'phone'         => $data['profile']['phone'],
            'address'       => $data['profile']['address'],
            'date_of_birth' => $data['profile']['date_of_birth'],
            'bio'           => $data['profile']['bio'],
            'facebook'      => $data['profile']['facebook'],
            'instagram'     => $data['profile']['instagram'],
            'twitter'       => $data['profile']['twitter'],
        ];
    }

    private function responseForAgent(array $data)
    {
        return [
            'id'                                  => $data['id'],
            'first_name'                          => $data['first_name'],
            'last_name'                           => $data['last_name'],
            'handle'                              => $data['handle'],
            'email'                               => $data['email'],
            'avatar'                              => $data['avatar'],
            'role'                                => $data['role']['name'],
            'status'                              => $data['status'],
            'phone'                               => $data['profile']['phone'],
            'address'                             => $data['profile']['address'],
            'date_of_birth'                       => $data['profile']['date_of_birth'],
            'contract_year_start'                 => $data['profile']['contract_year_start'],
            'total_commission_this_contract_year' => $data['profile']['total_commission_this_contract_year'],
            'bio'                                 => $data['profile']['bio'],
            'facebook'                            => $data['profile']['facebook'],
            'instagram'                           => $data['profile']['instagram'],
            'twitter'                             => $data['profile']['twitter'],
        ];
    }
}
