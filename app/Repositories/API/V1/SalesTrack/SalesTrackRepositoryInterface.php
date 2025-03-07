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
     * Summary of agentMonthlyColseSalesTrack
     * @param int $userId
     * @param string $startOfMonth
     * @param string $endOfMonth
     */
    public function agentMonthlyColseSalesTrack(int $usetId, string $startOfMonth, string $endOfMonth);

    /**
     * Summary of businessMonthlyColseSalesTrack
     * @param int $businessId
     * @param string $startOfMonth
     * @param string $endOfMonth
     */
    public function businessMonthlyColseSalesTrack(int $businessId, string $startOfMonth, string $endOfMonth);

    /**
     * agentCurrentQuarterColseSalesTrack
     * @param int $userId
     * @param string $quarterStart
     * @param string $quarterEnd
     */
    public function agentCurrentQuarterColseSalesTrack(int $userId, string $quarterStart, string $quarterEnd);

    /**
     * businessCurrentQuarterColseSalesTrack
     * @param int $businessId
     * @param string $quarterStart
     * @param string $quarterEnd
     */
    public function businessCurrentQuarterColseSalesTrack(int $businessId, string $quarterStart, string $quarterEnd);


    /**
     * agentCurrentYearColseSalesTrack
     * @param int $userId
     * @param string $yearStart
     * @param string $yearEnd
     */
    public function agentCurrentYearColseSalesTrack(int $userId, string $yearStart, string $yearEnd);


    /**
     * businessCurrentYearColseSalesTrack
     * @param int $businessId
     * @param string $yearStart
     * @param string $yearEnd
     */
    public function businessCurrentYearColseSalesTrack(int $businessId, string $yearStart, string $yearEnd);
}
