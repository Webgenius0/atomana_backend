<?php

namespace App\Services\API\V1\Property\AccessInstruction;

use App\Models\PropertyAccessInstruction;
use App\Repositories\API\V1\Property\AccessInstruction\AccessInstructionRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AccessInstructionService
{
    private AccessInstructionRepositoryInterface $accessInstructionRepository;
    private $businessId;

    /**
     * construct
     * @param \App\Repositories\API\V1\Property\AccessInstruction\AccessInstructionRepositoryInterface $accessInstructionRepository
     */
    public function __construct(AccessInstructionRepositoryInterface $accessInstructionRepository)
    {
        $this->accessInstructionRepository = $accessInstructionRepository;
        $this->businessId                  = Auth::user()->business()->id;
    }

    /**
     * getIndex
     */
    public function getIndex()
    {
        try {
            $perPage = request()->query("per_page", 25);
            return $this->accessInstructionRepository->getList($this->businessId, $perPage);
        } catch (Exception $e) {
            Log::error('AccessInstructionService::getIndex', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * createAccessInstruction
     * @param array $data
     * @return \App\Models\PropertyAccessInstruction
     */
    public function createAccessInstruction(array $data): PropertyAccessInstruction
    {
        try {
            return $this->accessInstructionRepository->create($data);
        } catch (Exception $e) {
            Log::error('AccessInstructionService::createAccessInstruction', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * showSingleAccessInstruction
     * @param int $accessInstructionId
     * @return \App\Models\PropertyAccessInstruction
     */
    public function showSingleAccessInstruction(int $accessInstructionId): PropertyAccessInstruction
    {
        try {
            return $this->accessInstructionRepository->show($accessInstructionId);
        } catch (Exception $e) {
            Log::error('AccessInstructionService::showSingleAccessInstruction', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
