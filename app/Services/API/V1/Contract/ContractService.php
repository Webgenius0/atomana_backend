<?php

namespace App\Services\API\V1\Contract;

use App\Models\Contract;
use App\Repositories\API\V1\Contract\ContractRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ContractService
{
    /**
     *
     * @var ContractRepositoryInterface
     */
    protected ContractRepositoryInterface $contractRepository;
    protected int $userId;
    protected int $businessId;

    /**
     * construct
     * @param \App\Repositories\API\V1\Contract\ContractRepositoryInterface $contractRepository
     */
    public function __construct(ContractRepositoryInterface $contractRepository)
    {
        $this->contractRepository = $contractRepository;
        $this->userId = Auth::user()->id;
        $this->businessId = Auth::user()->business()->id;
    }

    /**
     * getAllContracts
     */
    public function getAllContracts()
    {
        try {
            $perPage = request()->query('per_page');
            return $this->contractRepository->getAllContractsByBusiness($this->businessId, $perPage);
        } catch (Exception $e) {
            Log::error('ContractService:getAllContracts', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * createContract
     * @param array $data
     * @return \App\Models\Contract
     */
    public function createContract(array $data): Contract
    {
        try {
            return $this->contractRepository->createContract($data, $this->businessId, $this->userId);
        } catch (Exception $e) {
            Log::error('ContractService:createContract', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    /**
     * showContract
     * @param int $id
     * @return Contract
     */
    public function showContract(int $id): Contract
    {
        try {
            return $this->contractRepository->showContract($id);
        } catch (Exception $e) {
            Log::error('ContractService:createContract', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
