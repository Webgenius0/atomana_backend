<?php

namespace App\Repositories\API\V1\SalesTrack;

use App\Models\SalesTrack;
use Exception;
use Illuminate\Support\Facades\Log;

class SalesTrackRepository implements SalesTrackRepositoryInterface
{

    /**
     * get Sales Track By Business
     * @param int $businessId
     * @param int $per_page
     */
    public function getSalesTrackByBusiness(int $businessId, int $per_page = 25)
    {
        try {
            return SalesTrack::select([
                'id',
                'user_id',
                'property_id',
                'price',
                'status',
                'note',
            ])->with(['user:id,first_name,last_name', 'property:id,address'])->whereBusinessId($businessId)->latest()->paginate($per_page);
        } catch (Exception $e) {
            Log::error('SalesTrakeRepository::getSalesTrackByBusiness', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Create salesTrack
     * @param array $credentials
     * @param int $businessId
     * @return SalesTrack
     */
    public function create(array $credentials, int $businessId): SalesTrack
    {
        try {
            return SalesTrack::create([
                'business_id' => $businessId,
                'user_id' => $credentials['user_id'],
                'property_id' => $credentials['property_id'],
                'price' => $credentials['price'],
                'status' => $credentials['status'],
                'expiration_date' => $credentials['expiration_date'],
                'note' => $credentials['note'],
            ]);
        } catch (Exception $e) {
            Log::error('SalesTrakeRepository::create', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
