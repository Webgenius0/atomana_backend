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
                'note' => $credentials['note'],
            ]);
        } catch (Exception $e) {
            Log::error('SalesTrakeRepository::create', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    /**
     * Summary of agentMonthlyColseSalesTrack
     * @param int $userId
     * @param string $startOfMonth
     * @param string $endOfMonth
     */
    public function agentMonthlyColseSalesTrack(int $userId, string $startOfMonth, string $endOfMonth)
    {
        try {
            return SalesTrackView::where('user_id', $userId)
                ->where('status', 'close')
                ->whereBetween('close_date', [$startOfMonth, $endOfMonth])
                ->sum('purchase_price');
        } catch (Exception $e) {
            Log::error('SalesTrakeRepository::agentColseSalesTrack', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Summary of businessMonthlyColseSalesTrack
     * @param int $businessId
     * @param string $startOfMonth
     * @param string $endOfMonth
     */
    public function businessMonthlyColseSalesTrack(int $businessId, string $startOfMonth, string $endOfMonth)
    {
        try {
            return SalesTrackView::where('business_id', $businessId)
                ->where('status', 'close')
                ->whereBetween('close_date', [$startOfMonth, $endOfMonth])
                ->sum('purchase_price');
        } catch (Exception $e) {
            Log::error('SalesTrakeRepository::agentColseSalesTrack', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    /**
     * agentCurrentQuarterColseSalesTrack
     * @param int $userId
     * @param string $quarterStart
     * @param string $quarterEnd
     */
    public function agentCurrentQuarterColseSalesTrack(int $userId, string $quarterStart, string $quarterEnd)
    {
        try {
            // Query for sales within the current quarter
            return SalesTrackView::where('user_id', $userId)
                ->where('status', 'close')
                ->whereBetween('close_date', [$quarterStart, $quarterEnd])
                ->sum('purchase_price');
        } catch (Exception $e) {
            Log::error('SalesTrackRepository::agentCurrentQuarterColseSalesTrack', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * businessCurrentQuarterColseSalesTrack
     * @param int $businessId
     * @param string $quarterStart
     * @param string $quarterEnd
     */
    public function businessCurrentQuarterColseSalesTrack(int $businessId, string $quarterStart, string $quarterEnd)
    {
        try {
            // Query for sales within the current quarter
            return SalesTrackView::where('business_id', $businessId)
                ->where('status', 'close')
                ->whereBetween('close_date', [$quarterStart, $quarterEnd])
                ->sum('purchase_price');
        } catch (Exception $e) {
            Log::error('SalesTrackRepository::agentCurrentQuarterColseSalesTrack', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * agentCurrentYearColseSalesTrack
     * @param int $userId
     * @param string $yearStart
     * @param string $yearEnd
     */
    public function agentCurrentYearColseSalesTrack(int $userId, string $yearStart, string $yearEnd)
    {
        try {
            return SalesTrackView::where('user_id', $userId)
                ->where('status', 'close')
                ->whereBetween('close_date', [$yearStart, $yearEnd])
                ->sum('purchase_price');
        } catch (Exception $e) {
            Log::error('SalesTrackRepository::agentCurrentYearColseSalesTrack', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    /**
     * businessCurrentYearColseSalesTrack
     * @param int $businessId
     * @param string $yearStart
     * @param string $yearEnd
     */
    public function businessCurrentYearColseSalesTrack(int $businessId, string $yearStart, string $yearEnd)
    {
        try {
            return SalesTrackView::where('business_id', $businessId)
                ->where('status', 'close')
                ->whereBetween('close_date', [$yearStart, $yearEnd])
                ->sum('purchase_price');
        } catch (Exception $e) {
            Log::error('SalesTrackRepository::businessCurrentYearColseSalesTrack', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
