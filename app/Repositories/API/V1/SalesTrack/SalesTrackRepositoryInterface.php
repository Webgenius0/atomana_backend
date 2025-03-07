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
     * Summary of agentColseSalesTrack
     * @param int $userId
     */
    public function agentColseSalesTrack(int $usetId);

    /**
     * Summary of businessColseSalesTrack
     * @param int $businessId
     */
    public function businessColseSalesTrack(int $businessId);
}
