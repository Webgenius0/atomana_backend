<?php

namespace App\Repositories\API\V1\OpenHouse;

use App\Models\OpenHouseFeedback;
use Exception;
use Illuminate\Support\Facades\Log;

class FeedbackRepository implements FeedbackRepositoryInterface
{
    /**
     * createOpenHouseFeedback
     * @param array $data
     * @param int $userId
     * @param int $businessId
     * @param int $propertyId
     * @return OpenHouseFeedback
     */
    public function createOpenHouseFeedback(array $data, int $userId, int $businessId, int $propertyId): OpenHouseFeedback
    {
        try {
            return OpenHouseFeedback::create([
                'user_id'             => $userId,
                'business_id'         => $businessId,
                'property_id'         => $propertyId,
                'open_house_id'       => $data['open_house_id'],
                'people_count'        => $data['people_count'],
                'feedback'            => $data['feedback'],
                'additional_feedback' => $data['additional_feedback'],
            ]);
        } catch (Exception $e) {
            Log::error('API\V1\OpenHouse\FeedbackRepository:createOpenHouseFeedback');
            throw $e;
        }
    }


    /**
     * getFeebackByOpenHouseId
     * @param int $openHouseId
     */
    public function getFeebacksOfOpenHouseId(int $openHouseId, int $perPage)
    {
        try {
            return OpenHouseFeedback::select(['id', 'user_id', 'people_count', 'feedback', 'additional_feedback'])
            ->with(['user:id,first_name,last_name,handle,avatar'])->whereOpenHouseId($openHouseId)->orderBy('created_at', 'desc')->paginate($perPage);
        } catch (Exception $e) {
            Log::error('API\V1\OpenHouse\FeedbackRepository:getFeebackByOpenHouseId');
            throw $e;
        }
    }
}
