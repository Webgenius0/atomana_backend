<?php

namespace App\Repositories\API\V1\Contract;

use App\Models\Contract;
use Exception;
use Illuminate\Support\Facades\Log;

class ContractRepository implements ContractRepositoryInterface
{
    /**
     * get All Contracts By Business
     * @param int $businessId
     * @param mixed $perPage
     */
    public function getAllContractsByBusiness(int $businessId, $perPage = 25)
    {
        try {
            return Contract::whereBusinessId($businessId)->paginate($perPage);
        } catch (Exception $e) {
            Log::error('ContractRepository:createContract', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * createContract
     * @param array $data
     * @param int $businessId
     * @param int $userId
     * @return Contract
     */
    public function createContract(array $data, int $businessId, int $userId): Contract
    {
        try {
            return Contract::create([
                'business_id'          => $businessId,
                'agent'                => $userId,
                'address'              => $data['address'],
                'closing_data'         => $data['closing_data'],
                'is_co_listing'        => $data['is_co_listing'],
                'co_agent'             => $data['co_agent'],
                'represent'            => $data['represent'],
                'date_listed'          => $data['date_listed'],
                'price'                => $data['price'],
                'contract_data'        => $data['contract_data'],
                'commision_percentage' => $data['commision_percentage'],
                'property_source_id'   => $data['property_source_id'],
                'name'                 => $data['name'],
                'company'              => $data['company'],
                'email'                => $data['email'],
                'phone'                => $data['phone'],
                'comment'              => $data['comment'],
            ]);
        } catch (Exception $e) {
            Log::error('ContractRepository:createContract', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function updateContract(int $id, array $data) {}
}
