<?php

namespace App\Repositories\API\V1\OpenHouse;

use App\Models\OpenHouse;

interface OpenHouseRepositoryInterface
{
    /**
     * storeOpenHourse
     * @param array $credentials
     * @return OpenHouse
     */
    public function storeOpenHourse(array $credentials, int $businessId): OpenHouse;

    /**
     * openHouseById
     * @param int $id
     * @return OpenHouse
     */
    public function openHouseById(int $id): OpenHouse;
}
