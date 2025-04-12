<?php

namespace App\Repositories\API\V1\OpenHouse;

use App\Models\OpenHouse;
use Exception;
use Illuminate\Support\Facades\Log;

class OpenHouseRepository implements OpenHouseRepositoryInterface
{
    /**
     * listInDesc
     * @param int $businessId
     * @param int $perPage
     */
    public function listInDesc(int $businessId, int $perPage)
    {
        try {
            return OpenHouse::select(['id', 'property_id'])->with([
                'property:id,address',
                ])->orderBy('created_at', 'desc')->whereBusinessId($businessId)->paginate($perPage);
        } catch (Exception $e) {
            Log::error('App\Repositories\API\V1\OpenHouse\OpenHouseRepository:listOfOpenHouseWithResponse', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * storeOpenHourse
     * @param array $credentials
     * @param int $businessId
     * @param int $userId
     * @return OpenHouse
     */
    public function storeOpenHourse(array $credentials, int $businessId, int $userId): OpenHouse
    {
        try {
            return OpenHouse::create([
                'business_id' => $businessId,
                'property_id' => $credentials['property_id'],
                'user_id'     => $userId,
                'date'        => $credentials['date'],
                'start_time'  => $credentials['start_time'],
                'end_time'    => $credentials['end_time'],
                'sign_number' => $credentials['sign_number'],
            ]);
        } catch (Exception $e) {
            Log::error('App\Repositories\API\V1\OpenHouse\OpenHouseRepository:storeOpenHourse', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * openHouseById
     * @param int $id
     * @return OpenHouse
     */
    public function openHouseById(int $id): OpenHouse
    {
        try {
            return OpenHouse::findOrFail($id);
        } catch (Exception $e) {
            Log::error('App\Repositories\API\V1\OpenHouse\OpenHouseRepository:openHouseById', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * openHouseInfoById
     * @param int $id
     * @return OpenHouse
     */
    public function openHouseInfoById(int $id): OpenHouse
    {
        try {
            return OpenHouse::with(['user', 'property', 'property.coAgent'])->findOrFail($id);
        } catch (Exception $e) {
            Log::error('App\Repositories\API\V1\OpenHouse\OpenHouseRepository:openHouseById', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * getList
     * @param int $businessId
     */
    public function getList(int $businessId): mixed
    {
        try {
            return OpenHouse::select(['id', 'property_id'])->whereBusinessId($businessId)->with(['property:id,address'])->get();
        } catch (Exception $e) {
            Log::error('Repositories\API\V1\OpenHouse\OpenHouseRepository:getList', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
