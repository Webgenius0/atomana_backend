<?php

namespace App\Services\API\V1\SalesTrack;

use App\Models\SalesTrack;
use App\Repositories\API\V1\SalesTrack\SalesTrackRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class SalesTrackService
{
    protected SalesTrackRepositoryInterface $salesTrackRepository;

    /**
     * construct
     * @param SalesTrackRepositoryInterface $salesTrackRepository
     */
    public function __construct(SalesTrackRepositoryInterface $salesTrackRepository)
    {
        $this->salesTrackRepository = $salesTrackRepository;
    }

    /**
     * store Sales Track
     * @param array $credentials
     * @return SalesTrack
     */
    public function storeSalesTrack(array $credentials):SalesTrack
    {
        try {
            return $this->salesTrackRepository->create($credentials);
        } catch (Exception $e) {
            Log::error('SalesTrackService::storeSalesTrack', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
