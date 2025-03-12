<?php

namespace App\Services\API\V1\Property\Source;

use App\Repositories\API\V1\Property\Source\PropertySourceRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class PropertySourceService
{
    protected PropertySourceRepositoryInterface $propertySourceRepository;

    /**
     * construct
     * @param \App\Repositories\API\V1\Property\Source\PropertySourceRepositoryInterface $propertySourceRepository
     */
    public function __construct(PropertySourceRepositoryInterface $propertySourceRepository)
    {
        $this->propertySourceRepository = $propertySourceRepository;
    }


    /**
     * getDropdown
     * @return \Illuminate\Database\Eloquent\Collection<int, \App\Models\PropertySource>
     */
    public function getDropdown(): Collection
    {
        try {
            return $this->propertySourceRepository->getSource();
        }catch (Exception $e) {
            Log::error('App\Services\API\V1\Property\Source\PropertySourceService::getDropdown', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
