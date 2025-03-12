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
     * getIndex
     * @return \Illuminate\Database\Eloquent\Collection<int, \App\Models\PropertySource>
     */
    public function getIndex(): Collection
    {
        try {
            return $this->propertySourceRepository->getSource();
        }catch (Exception $e) {
            Log::error('App\Services\API\V1\Property\Source\PropertySourceService::getIndex', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
