<?php

namespace App\Repositories\API\V1\Property;

interface PropertyRepositoryInterface
{
    public function propertiesOftheBusiness();

    public function propertiesOfTheAgent();

    public function createProperty($credentials, $userId, $businessId);
}
