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
        try {
            $perPage = request()->query('per_page', 25);
            return $this->propertyRepository->propertiesOftheBusiness($this->user->business()->id, $perPage);
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
            $searchKey = request()->query('search') ?? '';
            if ($searchKey == '')
                return [];
            $properties = null;
            if ($this->user->role->id == 2) {
                $properties = $this->propertyRepository->searchPropertiesOfBusiness($this->user->business()->id, $searchKey);
            } else {
                $properties = $this->propertyRepository->searchPropertiesOfTheAgent($this->user->id, $searchKey);
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
    public function storeProperty(array $credentials): Property
    {
        try {
            $property = $this->propertyRepository->createProperty($credentials, $this->user->id, $this->user->business()->id);
            return $property;
        } catch (Exception $e) {
            Log::error('PropertyService::storeProperty', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * updateProperty
     * @param \App\Models\Property $property
     * @param array $data
     */
    public function updateProperty(Property $property, array $data)
    {
        try {
            return $this->propertyRepository->updateProperty($property, $data);
        } catch (Exception $e) {
            Log::error('PropertyService:bulkDestory', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * bulkDestory
     * @param array $ids
     */
    public function bulkDestory(array $ids)
    {
        try {
            return $this->propertyRepository->bulkDelete($ids);
        } catch (Exception $e) {
            Log::error('PropertyService:bulkDestory', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
