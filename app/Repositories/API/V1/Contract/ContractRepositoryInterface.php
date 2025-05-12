<?php

namespace App\Repositories\API\V1\Contract;

use App\Models\Contract;

interface ContractRepositoryInterface
{
    /**
     * get All Contracts By Business
     * @param int $businessId
     * @param mixed $perPage
     */
    public function getAllContractsByBusiness(int $businessId, $perPage = 25);

    /**
     * createContract
     * @param array $data
     * @param int $businessId
     * @param int $userId
     * @return Contract
     */
    public function createContract(array $data, int $businessId, int $userId): Contract;

    /**
     * showContract
     * @param int $id
     * @return Contract
     */
    public function showContract(int $id): Contract;

    /**
     * bulkDelete
     * @param array $ids
     * @return void
     */
    public function bulkDelete(array $ids): void;
}
