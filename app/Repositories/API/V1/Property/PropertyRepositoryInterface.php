<?php

namespace App\Repositories\API\V1\Property;

use App\Models\Property;

interface PropertyRepositoryInterface
{
    /**
     * properties Of the Business
     * @param int $businessId
     * @param int $perPage
     */
    public function propertiesOftheBusiness(int $businessId, int $perPage);

    /**
     * searchPropertiesOfBusiness
     * @param int $businessId
     * @param string $searchKey
     */
    public function searchPropertiesOfBusiness(int $businessId, string $searchKey);

    /**
     * searchPropertiesOfTheAgent
     * @param int $userId
     * @param string $searchKey
     */
    public function searchPropertiesOfTheAgent(int $userId, string $searchKey);

    /**
     * Creating a property
     * @param array $credentials
     * @param int $userId
     * @param int $businessId
     * @return Property
     */
    public function createProperty(array $credentials, int $userId, int $businessId): Property;

    /**
     * showById
     * @param int $propertyId
     * @return Property
     */
    public function showDetailsById(int $propertyId): Property;
}
