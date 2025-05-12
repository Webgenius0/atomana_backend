<?php

namespace App\Repositories\API\V1\Property\AccessInstruction;

use App\Models\PropertyAccessInstruction;

interface AccessInstructionRepositoryInterface
{
    /**
     * getList
     * @param int $businessId
     * @param int $perPage
     */
    public function getList(int $businessId, int $perPage = 25);

    /**
     * create
     * @param array $data
     * @return PropertyAccessInstruction
     */
    public function create(array $data): PropertyAccessInstruction;

    /**
     * show
     * @param int $id
     * @return PropertyAccessInstruction
     */
    public function show(int $accessInstructionId): PropertyAccessInstruction;

    /**
     * bulkDelete
     * @param array $ids
     * @return void
     */
    public function bulkDelete(array $ids): void;
}
