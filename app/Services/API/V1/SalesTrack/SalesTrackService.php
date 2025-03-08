<?php

namespace App\Services\API\V1\SalesTrack;

use App\Models\SalesTrack;
use App\Repositories\API\V1\SalesTrack\SalesTrackRepositoryInterface;
use App\Repositories\API\V1\Target\TargetRepositoryInterface;
use App\Traits\V1\DateManager;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SalesTrackService
{
    use DateManager;
    protected $user;
    protected $businessId;
    protected SalesTrackRepositoryInterface $salesTrackRepository;
    protected TargetRepositoryInterface $targetRepository;

    /**
     * construct
     * @param \App\Repositories\API\V1\SalesTrack\SalesTrackRepositoryInterface $salesTrackRepository
     * @param \App\Repositories\API\V1\Target\TargetRepositoryInterface $targetRepository
     */
    public function __construct(SalesTrackRepositoryInterface $salesTrackRepository, TargetRepositoryInterface $targetRepository)
    {
        $this->user                 = Auth::user();
        $this->businessId           = Auth::user()->business()->id;
        $this->salesTrackRepository = $salesTrackRepository;
        $this->targetRepository     = $targetRepository;
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
    public function storeSalesTrack(array $credentials): SalesTrack
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
     * @param string $filter filter operation monthly|quarterly|yearly
     */
    public function currentSalesStatistics(string $filter)
    {
        try {
            $role = $this->user->role->slug;
            $response = null;
            if ($role == 'admin') {
                $response = $this->adminCurrentStatus($filter);
            } else if ($role == 'agent') {
                $response = $this->agentCurrentStatus($filter);
            }

            return $response;
        } catch (Exception $e) {
            Log::error('SalesTrackService::currentSalesStatistics', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * *
     * @param string $filter
     * @return array{price: float, target: float}
     */
    private function adminCurrentStatus(string $filter): array
    {
        try {
            $currentDate = Carbon::now();
            $currentAmount = null;
            $target = null;
            $percentage = null;
            if ($filter == 'monthly') {
                $startOfMonth = $this->getStartOfMonth($currentDate);
                $endOfMonth = $currentDate->endOfMonth();
                $currentAmount = $this->salesTrackRepository->businessMonthlyColseSalesTrack($this->businessId, $startOfMonth, $endOfMonth);
                $target = $this->targetRepository->getRangeTarget($this->user->id, $startOfMonth, $endOfMonth, 'current_sales');
            } else if ($filter == 'quarterly') {
                // Determine the start and end of the current quarter
                $quarterStart = $this->getCurrentQuarterStartDate($currentDate);
                $quarterEnd = $this->getCurrentQuarterEndDate($currentDate);
                $currentAmount = $this->salesTrackRepository->businessCurrentQuarterColseSalesTrack($this->businessId, $quarterStart, $quarterEnd);
                $target = $this->targetRepository->getRangeTarget($this->user->id, $quarterStart, $quarterEnd, 'current_sales');
            } else if ($filter == 'yearly') {
                $yearStart = $this->getCurrentYearStartDate($currentDate);
                $yearEnd = $this->getCurrentYearEndDate($currentDate);
                $currentAmount = $this->salesTrackRepository->businessCurrentYearColseSalesTrack($this->businessId, $yearStart, $yearEnd);
                $target = $this->targetRepository->getRangeTarget($this->user->id, $yearStart, $yearEnd, 'current_sales');
            }
            if ($target) {
                $percentage = ($currentAmount * 100) / $target;
            }
            return [
                'target' => number_format((float) $target, 2),
                'target_fill' => number_format((float) $currentAmount, 2),
                'percentage' => number_format((float) $percentage, 2),
            ];
        } catch (Exception $e) {
            Log::error('SalesTrackService::adminCurrentStatus', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * agentCurrentStatus
     * @param string $filter
     * @return array{price: float, target: float}
     */
    private function agentCurrentStatus(string $filter): array
    {
        try {
            $currentDate = Carbon::now();
            $currentAmount = null;
            $target = null;
            $percentage = null;
            if ($filter == 'monthly') {
                $startOfMonth = $this->getStartOfMonth($currentDate);
                $endOfMonth = $currentDate->endOfMonth();
                $currentAmount = $this->salesTrackRepository->agentMonthlyColseSalesTrack($this->user->id, $startOfMonth, $endOfMonth);
                $target = $this->targetRepository->getRangeTarget($this->user->id, $startOfMonth, $endOfMonth, 'current_sales');
            } else if ($filter == 'quarterly') {
                $quarterStart = $this->getCurrentQuarterStartDate($currentDate);
                $quarterEnd = $this->getCurrentQuarterEndDate($currentDate);
                $currentAmount = $this->salesTrackRepository->agentCurrentQuarterColseSalesTrack($this->user->id, $quarterStart, $quarterEnd);
                $target = $this->targetRepository->getRangeTarget($this->user->id, $quarterStart, $quarterEnd, 'current_sales');
            } else if ($filter == 'yearly') {
                $yearStart = $this->getCurrentYearStartDate($currentDate);
                $yearEnd = $this->getCurrentYearEndDate($currentDate);
                $currentAmount = $this->salesTrackRepository->agentCurrentYearColseSalesTrack($this->user->id, $yearStart, $yearEnd);
                $target = $this->targetRepository->getRangeTarget($this->user->id, $yearStart, $yearEnd, 'current_sales');
            }
            return [
                'target' => number_format((float) $target, 2),
                'target_fill' => number_format((float) $currentAmount, 2),
                'percentage' => number_format((float) $percentage, 2),
            ];
        } catch (Exception $e) {
            Log::error('SalesTrackService::agentCurrentStatus', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

}
