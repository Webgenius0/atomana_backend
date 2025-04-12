<?php

namespace App\Repositories\API\V1\OpenHouse;

use App\Models\OpenHouseFeedback;

interface FeedbackRepositoryInterface
{
    /**
     * createOpenHouseFeedback
     * @param array $data
     * @param int $userId
     * @param int $businessId
     * @param int $propertyId
     * @return OpenHouseFeedback
     */
    public function createOpenHouseFeedback(array $data, int $userId, int $businessId, int $propertyId): OpenHouseFeedback;


    /**
     * getFeebackByOpenHouseId
     * @param int $openHouseId
     */
    public function getFeebacksOfOpenHouseId(int $openHouseId, int $perPage);
}
