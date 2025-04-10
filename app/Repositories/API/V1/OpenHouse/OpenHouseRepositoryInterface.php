<?php

namespace App\Repositories\API\V1\OpenHouse;

use App\Models\OpenHouse;

interface OpenHouseRepositoryInterface
{
    /**
     * listOfOpenHouseWithResponse
     * @param int $businessId
     * @param int $perPage
     */
    public function listOfOpenHouseWithResponse(int $businessId, int $perPage);

    /**
     * storeOpenHourse
     * @param array $credentials
     * @param int $businessId
     * @param int $userId
     * @return OpenHouse
     */
    public function storeOpenHourse(array $credentials, int $businessId, int $userId): OpenHouse;

    /**
     * openHouseById
     * @param int $id
     * @return OpenHouse
     */
    public function openHouseById(int $id): OpenHouse;

    /**
     * getList
     * @param int $businessId
     */
    public function getList(int $businessId): mixed;
}
