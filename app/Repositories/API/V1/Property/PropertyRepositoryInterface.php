<?php

namespace App\Repositories\API\V1\Property;

use App\Models\Property;

interface PropertyRepositoryInterface
{
    public function propertiesOftheBusiness(int $businessId);

    public function propertiesOfTheAgent(int $userId);

    /**
     * Creating a property
     * @param array $credentials
     * @param int $userId
     * @param int $businessId
     * @return Property
     */
    public function createProperty(array $credentials, int $userId, int $businessId):Property;
}
