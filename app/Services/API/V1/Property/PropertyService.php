<?php

namespace App\Services\API\V1\Property;

use App\Models\Property;
use App\Repositories\API\V1\Property\PropertyRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PropertyService
{
    protected PropertyRepositoryInterface $propertyRepository;
    protected $user;

    /**
     * Summary of __construct
     * @param \App\Repositories\API\V1\Property\PropertyRepositoryInterface $propertyRepository
     */
    public function __construct(PropertyRepositoryInterface $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
        $this->user = Auth::user();
    }

    /**
     * propertyesOfBusiness
     */
    public function propertyesOfBusiness()
    {
        try{
            return $this->propertyRepository->propertiesOftheBusiness($this->user->business()->id);
        }catch (Exception $e) {
            Log::error('PropertyService::propertyesOfBusiness', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * showPropertyDetails
     * @param int $showById
     * @return Property
     */
    public function showPropertyDetails(int $showById): Property
    {
        try {
            return $this->propertyRepository->showDetailsById($showById);
        }catch (Exception $e) {
            Log::error('PropertyService::showPropertyDetails', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * showDropdown of properties
     */
    public function showDropdown()
    {
        try {
            $properties = null;
            if ($this->user->role->id == 2) {
                $properties = $this->propertyRepository->propertiesOftheBusiness($this->user->business()->id);
            }else {
                $properties = $this->propertyRepository->propertiesOfTheAgent($this->user->id);
            }
            return $properties;
        } catch (Exception $e) {
            Log::error('PropertyService::showDropdown', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * storing the property
     * @param array $credentials
     * @return Property
     */
    public function storeProperty(array $credentials):Property
    {
        try {
            $property = $this->propertyRepository->createProperty($credentials, $this->user->id, $this->user->business()->id);
            return $property;
        } catch (Exception $e) {
            Log::error('PropertyService::storeProperty', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
