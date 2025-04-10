<?php

namespace App\Repositories\API\V1\Property\AccessInstruction;

use App\Models\PropertyAccessInstruction;

interface AccessInstructionRepositoryInterface
{
    /**
     * index
     * @param int $businessId
     * @param int $perPage
     */
    public function index(int $businessId, int $perPage = 25);

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
    public function show(int $id): PropertyAccessInstruction;
}
