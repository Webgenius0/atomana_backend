<?php

namespace App\Repositories\API\V1\SalesTrack;

use App\Helpers\Helper;
use App\Models\SalesTrack;
use App\Models\SalesTrackView;
use Exception;
use Illuminate\Support\Facades\Log;

class SalesTrackRepository implements SalesTrackRepositoryInterface
{

    /**
     * get Sales Track By Business
     * @param int $businessId
     * @param int $perPage
     */
    public function getSalesTrackByBusiness(int $businessId, int $perPage = 25)
    {
        try {
            // return SalesTrack::select([
            //     'id',
            //     'user_id',
            //     'property_id',
            //     'price',
            //     'status',
            //     'note',
            // ])->with(['user:id,first_name,last_name', 'property:id,address'])->whereBusinessId($businessId)->latest()->paginate($perPage);

            return SalesTrackView::where('business_id', $businessId)
                ->orderBy('id', 'desc')
                ->paginate($perPage);
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
                'track_id' => Helper::generateUniqueId('sales_tracks', 'track_id'),
                'business_id' => $businessId,
                'user_id' => $credentials['user_id'],
                'property_id' => $credentials['property_id'],
                'price' => $credentials['price'],
                'status' => $credentials['status'],
                'date_under_contract' => $credentials['date_under_contract'],
                'closing_date' => $credentials['closing_date'],
                'purchase_price' => $credentials['purchase_price'],
                'buyer_seller' => $credentials['buyer_seller'],
                'referral_fee_pct' => $credentials['referral_fee_pct'],
                'commission_on_sale' => $credentials['commission_on_sale'],
                'note' => $credentials['note'],
            ]);
        } catch (Exception $e) {
            Log::error('SalesTrakeRepository::create', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
