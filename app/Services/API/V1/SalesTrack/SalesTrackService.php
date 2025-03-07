<?php

namespace App\Services\API\V1\SalesTrack;

use App\Models\SalesTrack;
use App\Repositories\API\V1\SalesTrack\SalesTrackRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SalesTrackService
{
    protected $user;
    protected $businessId;
    protected SalesTrackRepositoryInterface $salesTrackRepository;

    /**
     * construct
     * @param SalesTrackRepositoryInterface $salesTrackRepository
     */
    public function __construct(SalesTrackRepositoryInterface $salesTrackRepository)
    {
        $this->user                 = Auth::user();
        $this->businessId           = Auth::user()->business()->id;
        $this->salesTrackRepository = $salesTrackRepository;
    }

    /**
     * get Sales Track
     */
    public function getSalesTrack()
    {
        try {
            $perPage = request()->query('per_page', 25);
            return $this->salesTrackRepository->getSalesTrackByBusiness($this->businessId, $perPage);
        } catch (Exception $e) {
            Log::error('SalesTrackService::getSalesTrack', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * store Sales Track
     * @param array $credentials
     * @return SalesTrack
     */
    public function storeSalesTrack(array $credentials):SalesTrack
    {
        try {
            return $this->salesTrackRepository->create($credentials, $this->businessId);
        } catch (Exception $e) {
            Log::error('SalesTrackService::storeSalesTrack', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    /**
     * currentSalesStatistics
     * @param string $filter filter operation [month, quarter,  year]
     * @return array
     */
    public function currentSalesStatistics(string $filter)
    {
        try {
            $role = $this->user->role->slug;
            if ($role == 'admin')
            {

            }
            else if ($role == 'agent')
            {

            }

            return [
                'role' => $role,
            ];
        } catch (Exception $e) {
            Log::error('SalesTrackService::currentSalesStatistics', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
