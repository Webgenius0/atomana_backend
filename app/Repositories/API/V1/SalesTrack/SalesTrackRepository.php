<?php

namespace App\Repositories\API\V1\SalesTrack;

use App\Helpers\Helper;
use App\Models\SalesTrack;
use App\Models\SalesTrackView;
use Exception;
use Illuminate\Support\Facades\DB;
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
                'status' => $credentials['status'],
                'date_under_contract' => $credentials['date_under_contract'],
                'closing_date' => $credentials['closing_date'],
                'purchase_price' => $credentials['purchase_price'],
                'buyer_seller' => $credentials['buyer_seller'],
                'referral_fee_pct' => $credentials['referral_fee_pct'],
                'commission_on_sale' => $credentials['commission_on_sale'],
                'override_split' => $credentials['override_split'],
                'note' => $credentials['note'],
            ]);
        } catch (Exception $e) {
            Log::error('SalesTrakeRepository::create', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * agentColseSalesTrackTotalPurchasePriceByRange
     * @param int $userId
     * @param string $start
     * @param string $end
     */
    public function agentColseSalesTrackTotalPurchasePriceByRange(int $userId, string $start, string $end)
    {
        try {
            return SalesTrackView::where('user_id', $userId)
                ->where('status', 'close')
                ->whereBetween('closing_date', [$start, $end])
                ->sum('purchase_price');
        } catch (Exception $e) {
            Log::error('SalesTrakeRepository::agentColseSalesTrackTotalPurchasePriceByRange', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    /**
     * agentColseSalesTrackCount
     * @param int $userId
     * @param string $start
     * @param string $end
     */
    public function agentColseSalesTrackCount(int $userId, string $start, string $end)
    {
        try {
            return SalesTrackView::where('user_id', $userId)
                ->where('status', 'close')
                ->whereBetween('closing_date', [$start, $end])
                ->count();
        } catch (Exception $e) {
            Log::error('SalesTrackRepository::agentColseSalesTrackCount', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    /**
     * agentAvgSalesPrice
     * @param int $userId
     * @param string $start
     * @param string $end
     */
    public function agentAvgSalesPrice(int $userId, string $start, string $end)
    {
        try {
            return SalesTrackView::where('user_id', $userId)
                ->where('status', 'close')
                ->whereBetween('closing_date', [$start, $end])
                ->avg('purchase_price');
        } catch (Exception $e) {
            Log::error('SalesTrackRepository::agentAvgSalesPrice', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * agentVolumeSalesPrice
     * @param int $userId
     * @param string $start
     * @param string $end
     */
    public function agentVolumeSalesPrice(int $userId, string $start, string $end)
    {
        try {
            return SalesTrackView::where('user_id', $userId)
                ->where('status', 'close')
                ->whereBetween('closing_date', [$start, $end])
                ->sum('purchase_price');
        } catch (Exception $e) {
            Log::error('SalesTrackRepository::agentVolumeSalesPrice', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * agentPendingVolumePrice
     * @param int $userId
     * @param string $start
     * @param string $end
     */
    public function agentPendingVolumePrice(int $userId, string $start, string $end)
    {
        try {
            return SalesTrackView::where('user_id', $userId)
                ->where('status', 'pending')
                ->whereBetween('closing_date', [$start, $end])
                ->sum('purchase_price');
        } catch (Exception $e) {
            Log::error('SalesTrackRepository::agentPendingVolumePrice', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * agentActiveVolumePrice
     * @param int $userId
     * @param string $start
     * @param string $end
     */
    public function agentActiveVolumePrice(int $userId, string $start, string $end)
    {
        try {
            return SalesTrackView::where('user_id', $userId)
                ->where('status', 'active')
                ->whereBetween('closing_date', [$start, $end])
                ->sum('purchase_price');
        } catch (Exception $e) {
            Log::error('SalesTrackRepository::agentActiveVolumePrice', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * agentAverageListPrice
     * @param int $userId
     * @param string $start
     * @param string $end
     */
    public function agentAverageListPrice(int $userId, string $start, string $end)
    {
        try {
            return SalesTrackView::where('user_id', $userId)
                ->whereBetween('closing_date', [$start, $end])
                ->sum('purchase_price');
        } catch (Exception $e) {
            Log::error('SalesTrackRepository::agentAverageListPrice', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    /**
     * busnessColseSalesTrackTotalPurchasePriceByRange
     * @param int $businessId
     * @param string $start
     * @param string $end
     */
    public function busnessColseSalesTrackTotalPurchasePriceByRange(int $businessId, string $start, string $end)
    {
        try {
            return SalesTrackView::where('business_id', $businessId)
                ->where('status', 'close')
                ->whereBetween('closing_date', [$start, $end])
                ->sum('purchase_price');
        } catch (Exception $e) {
            Log::error('SalesTrackRepository::busnessColseSalesTrackTotalPurchasePriceByRange', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    /**
     * busnessColseSalesTrackCount
     * @param int $businessId
     * @param string $start
     * @param string $end
     */
    public function busnessColseSalesTrackCount(int $businessId, string $start, string $end)
    {
        try {
            return SalesTrackView::where('business_id', $businessId)
                ->where('status', 'close')
                ->whereBetween('closing_date', [$start, $end])
                ->count();
        } catch (Exception $e) {
            Log::error('SalesTrackRepository::busnessColseSalesTrackCount', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * topAgentsOfBusinessWithAvgPurchasePrice
     * @param int $businessId
     * @param string $start
     * @param string $end
     * @return \Illuminate\Database\Eloquent\Collection<int, SalesTrack>
     */
    public function topAgentsOfBusinessWithAvgPurchasePrice(int $businessId, string $start, string $end)
    {
        try {
            return SalesTrack::select(
                'user_id',
                DB::raw('ROUND(AVG(purchase_price), 2) as avg_purchase_price'),
                DB::raw('COUNT(id) as total_sales')
            )
                ->where('business_id', $businessId)
                ->whereBetween('closing_date', [$start, $end])
                ->groupBy('user_id')
                ->orderByDesc('avg_purchase_price')
                ->with(['user:id,first_name,last_name,handle'])
                ->limit(12)
                ->get();
        } catch (Exception $e) {
            Log::error('SalesTrackRepository::topAgentsOfBusinessWithAvgPurchasePrice', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * topAgentsOfBusinessWithSumPurchasePrice
     * @param int $businessId
     * @param string $start
     * @param string $end
     * @return \Illuminate\Database\Eloquent\Collection<int, SalesTrack>
     */
    public function topAgentsOfBusinessWithSumPurchasePrice(int $businessId, string $start, string $end)
    {
        try {
            return SalesTrack::select(
                'user_id',
                DB::raw('ROUND(SUM(purchase_price), 2) as sum_purchase_price'),
                DB::raw('COUNT(id) as count')
            )
                ->where('business_id', $businessId)
                ->whereBetween('closing_date', [$start, $end])
                ->groupBy('user_id')
                ->orderByDesc('sum_purchase_price')
                ->with(['user:id,first_name,last_name,handle'])
                ->limit(12)
                ->get();
        } catch (Exception $e) {
            Log::error('SalesTrackRepository::topAgentsOfBusinessWithSumPurchasePrice', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
