<?php

namespace App\Services\API\V1\Property\Type;

use App\Repositories\API\V1\Property\Type\PropertyTypeRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class PropertyTypeService
{
    protected PropertyTypeRepositoryInterface $propertyTypeRepository;
    protected $user;

    /**
     * construct
     * @param \App\Repositories\API\V1\Property\Type\PropertyTypeRepositoryInterface $propertyTypeRepository
     */
    public function __construct(PropertyTypeRepositoryInterface $propertyTypeRepository)
    {
        $this->propertyTypeRepository = $propertyTypeRepository;
    }

    /**
     * getDropdown
     * @return \Illuminate\Database\Eloquent\Collection<int, \App\Models\PropertyType>
     */
    public function getDropdown()
    {
        try {
            return $this->propertyTypeRepository->getList();
        }catch (Exception $e) {
            Log::error('PropertyTypeService::getDropdown', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
