<?php

namespace App\Repositories\API\V1\SalesTrack;

use App\Models\SalesTrack;

interface SalesTrackRepositoryInterface
{

    /**
     * get Sales Track By Business
     * @param int $businessId
     * @param int $per_page
     */
    public function getSalesTrackByBusiness(int $businessId, int $perPage = 25);

    /**
     * Create salesTrack
     * @param array $credentials
     * @param int $businessId
     * @return SalesTrack
     */
    public function create(array $credentials, int $businessId): SalesTrack;


    /**
     * agentColseSalesTrackTotalPurchasePriceByRange
     * @param int $userId
     * @param string $start
     * @param string $end
     */
    public function agentColseSalesTrackTotalPurchasePriceByRange(int $userId, string $start, string $end);

    /**
     * agentColseSalesTrackCount
     * @param int $userId
     * @param string $start
     * @param string $end
     */
    public function agentColseSalesTrackCount(int $userId, string $start, string $end);

    /**
     * busnessColseSalesTrackTotalPurchasePriceByRange
     * @param int $businessId
     * @param string $start
     * @param string $end
     */
    public function busnessColseSalesTrackTotalPurchasePriceByRange(int $businessId, string $start, string $end);

    /**
     * busnessColseSalesTrackCount
     * @param int $businessId
     * @param string $start
     * @param string $end
     */
    public function busnessColseSalesTrackCount(int $businessId, string $start, string $end);

}
