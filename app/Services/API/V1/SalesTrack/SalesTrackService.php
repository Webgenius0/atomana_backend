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
     * uniteSoldStatistics
     * @param string $filter
     * @return array|null
     */
    public function uniteSoldStatistics(string $filter)
    {
        try {
            $role = $this->user->role->slug;
            $response = null;
            if ($role == 'admin') {
                $response = $this->adminUnitesStatus($filter);
            } else if ($role == 'agent') {
                $response = $this->agentUnitesStatus($filter);
            }
            return $response;
        } catch (Exception $e) {
            Log::error('SalesTrackService::uniteSoldStatistics', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Summary of leaderboardAgents
     * @param mixed $sortedBy
     * @param mixed $filter
     * @return array
     */
    public function leaderboardAgents($sortedBy, $filter): array
    {
        try {
            $currentDate = Carbon::now();
            $list = null;
            $totalSales = null;
            if ($sortedBy == 'highest-avg-sales') {
                if ($filter == 'monthly') {
                    $startOfMonth = $this->getStartOfMonth($currentDate);
                    $endOfMonth = $currentDate->endOfMonth();
                    $totalSales = $this->salesTrackRepository->salesCountOnThatRange($this->businessId, $startOfMonth, $endOfMonth);
                    $list = $this->salesTrackRepository->topAgentsOfBusinessWithAvgPurchasePrice($this->businessId, $startOfMonth, $endOfMonth);
                } else if ($filter == 'quarterly') {
                    // Determine the start and end of the current quarter
                    $quarterStart = $this->getCurrentQuarterStartDate($currentDate);
                    $quarterEnd = $this->getCurrentQuarterEndDate($currentDate);
                    $totalSales = $this->salesTrackRepository->salesCountOnThatRange($this->businessId, $quarterStart, $quarterEnd);
                    $list = $this->salesTrackRepository->topAgentsOfBusinessWithAvgPurchasePrice($this->businessId, $quarterStart, $quarterEnd);
                } else if ($filter == 'yearly') {
                    $yearStart = $this->getCurrentYearStartDate($currentDate);
                    $yearEnd = $this->getCurrentYearEndDate($currentDate);
                    $totalSales = $this->salesTrackRepository->salesCountOnThatRange($this->businessId, $currentDate, $currentDate);
                    $list = $this->salesTrackRepository->topAgentsOfBusinessWithAvgPurchasePrice($this->businessId, $yearStart, $yearEnd);
                }
            } else {
                if ($filter == 'monthly') {
                    $startOfMonth = $this->getStartOfMonth($currentDate);
                    $endOfMonth = $currentDate->endOfMonth();
                    $totalSales = $this->salesTrackRepository->salesCountOnThatRange($this->businessId, $startOfMonth, $endOfMonth);
                    $list = $this->salesTrackRepository->topAgentsOfBusinessWithSumPurchasePrice($this->businessId, $startOfMonth, $endOfMonth);
                } else if ($filter == 'quarterly') {
                    // Determine the start and end of the current quarter
                    $quarterStart = $this->getCurrentQuarterStartDate($currentDate);
                    $quarterEnd = $this->getCurrentQuarterEndDate($currentDate);
                    $totalSales = $this->salesTrackRepository->salesCountOnThatRange($this->businessId, $quarterStart, $quarterEnd);
                    $list = $this->salesTrackRepository->topAgentsOfBusinessWithSumPurchasePrice($this->businessId, $quarterStart, $quarterEnd);
                } else if ($filter == 'yearly') {
                    $yearStart = $this->getCurrentYearStartDate($currentDate);
                    $yearEnd = $this->getCurrentYearEndDate($currentDate);
                    $totalSales = $this->salesTrackRepository->salesCountOnThatRange($this->businessId, $currentDate, $currentDate);
                    $list = $this->salesTrackRepository->topAgentsOfBusinessWithSumPurchasePrice($this->businessId, $yearStart, $yearEnd);
                }
            }
            return ['total_sales' => $totalSales, 'list' => $list];
        } catch (Exception $e) {
            Log::error('SalesTrackService::leaderboardAgents', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * avgSalesData
     * @param string $filter
     * @return array
     */
    public function agentSalesData(int $userId, string $filter): array
    {
        try {
            $currentDate = Carbon::now();
            $avgSales = null;
            $volumeSales = null;
            $pendingVolumeSales = null;
            $activeVolumeSales = null;
            $avgLisging = null;
            if ($filter == 'monthly') {
                $startOfMonth = $this->getStartOfMonth($currentDate);
                $endOfMonth = $currentDate->endOfMonth();
                $avgSales = $this->salesTrackRepository->agentAvgSalesPrice($userId, $startOfMonth, $endOfMonth);
                $volumeSales = $this->salesTrackRepository->agentVolumeSalesPrice($userId, $startOfMonth, $endOfMonth);
                $pendingVolumeSales = $this->salesTrackRepository->agentPendingVolumePrice($userId, $startOfMonth, $endOfMonth);
                $activeVolumeSales = $this->salesTrackRepository->agentActiveVolumePrice($userId, $startOfMonth, $endOfMonth);
                $avgLisging = $this->salesTrackRepository->agentAverageListPrice($userId, $startOfMonth, $endOfMonth);
            } else if ($filter == 'quarterly') {
                $quarterStart = $this->getCurrentQuarterStartDate($currentDate);
                $quarterEnd = $this->getCurrentQuarterEndDate($currentDate);
                $avgSales = $this->salesTrackRepository->agentAvgSalesPrice($userId, $quarterStart, $quarterEnd);
                $volumeSales = $this->salesTrackRepository->agentVolumeSalesPrice($userId, $quarterStart, $quarterEnd);
                $pendingVolumeSales = $this->salesTrackRepository->agentPendingVolumePrice($userId, $quarterStart, $quarterEnd);
                $activeVolumeSales = $this->salesTrackRepository->agentActiveVolumePrice($userId, $quarterStart, $quarterEnd);
                $avgLisging = $this->salesTrackRepository->agentAverageListPrice($userId, $quarterStart, $quarterEnd);
            } else if ($filter == 'yearly') {
                $yearStart = $this->getCurrentYearStartDate($currentDate);
                $yearEnd = $this->getCurrentYearEndDate($currentDate);
                $avgSales = $this->salesTrackRepository->agentAvgSalesPrice($userId, $yearStart, $yearEnd);
                $volumeSales = $this->salesTrackRepository->agentVolumeSalesPrice($userId, $yearStart, $yearEnd);
                $pendingVolumeSales = $this->salesTrackRepository->agentPendingVolumePrice($userId, $yearStart, $yearEnd);
                $activeVolumeSales = $this->salesTrackRepository->agentActiveVolumePrice($userId, $yearStart, $yearEnd);
                $avgLisging = $this->salesTrackRepository->agentAverageListPrice($userId, $yearStart, $yearEnd);
            }
            return [
                'avg_sales' => number_format((float) $avgSales, 2),
                'volume_ales' => number_format((float) $volumeSales, 2),
                'pending_volume_ales' => number_format((float) $pendingVolumeSales, 2),
                'active_volume_ales' => number_format((float) $activeVolumeSales, 2),
                'avg_lisging' => number_format((float) $avgLisging, 2),
            ];
        } catch (Exception $e) {
            Log::error('SalesTrackService::avgSalesData', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * adminCurrentStatus
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
                $currentAmount = $this->salesTrackRepository->busnessColseSalesTrackTotalPurchasePriceByRange($this->businessId, $startOfMonth, $endOfMonth);
                $target = $this->targetRepository->getRangeTarget($this->user->id, $startOfMonth, $endOfMonth, 'current_sales');
            } else if ($filter == 'quarterly') {
                // Determine the start and end of the current quarter
                $quarterStart = $this->getCurrentQuarterStartDate($currentDate);
                $quarterEnd = $this->getCurrentQuarterEndDate($currentDate);
                $currentAmount = $this->salesTrackRepository->busnessColseSalesTrackTotalPurchasePriceByRange($this->businessId, $quarterStart, $quarterEnd);
                $target = $this->targetRepository->getRangeTarget($this->user->id, $quarterStart, $quarterEnd, 'current_sales');
            } else if ($filter == 'yearly') {
                $yearStart = $this->getCurrentYearStartDate($currentDate);
                $yearEnd = $this->getCurrentYearEndDate($currentDate);
                $currentAmount = $this->salesTrackRepository->busnessColseSalesTrackTotalPurchasePriceByRange($this->businessId, $yearStart, $yearEnd);
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
                $currentAmount = $this->salesTrackRepository->agentAvgSalesPrice($this->user->id, $startOfMonth, $endOfMonth);
                $target = $this->targetRepository->getRangeTarget($this->user->id, $startOfMonth, $endOfMonth, 'current_sales');
            } else if ($filter == 'quarterly') {
                $quarterStart = $this->getCurrentQuarterStartDate($currentDate);
                $quarterEnd = $this->getCurrentQuarterEndDate($currentDate);
                $currentAmount = $this->salesTrackRepository->agentAvgSalesPrice($this->user->id, $quarterStart, $quarterEnd);
                $target = $this->targetRepository->getRangeTarget($this->user->id, $quarterStart, $quarterEnd, 'current_sales');
            } else if ($filter == 'yearly') {
                $yearStart = $this->getCurrentYearStartDate($currentDate);
                $yearEnd = $this->getCurrentYearEndDate($currentDate);
                $currentAmount = $this->salesTrackRepository->agentAvgSalesPrice($this->user->id, $yearStart, $yearEnd);
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
            Log::error('SalesTrackService::agentCurrentStatus', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * adminUnitesStatus
     * @param string $filter
     * @return array{current_count: string, percentage: string, target: string}
     */
    private function adminUnitesStatus(string $filter)
    {
        try {
            $currentDate = Carbon::now();
            $currentCount = null;
            $target = null;
            $percentage = null;
            if ($filter == 'monthly') {
                $startOfMonth = $this->getStartOfMonth($currentDate);
                $endOfMonth = $currentDate->endOfMonth();
                $currentCount = $this->salesTrackRepository->busnessColseSalesTrackCount($this->businessId, $startOfMonth, $endOfMonth);
                $target = $this->targetRepository->getRangeTarget($this->user->id, $startOfMonth, $endOfMonth, 'units_sold');
            } else if ($filter == 'quarterly') {
                // Determine the start and end of the current quarter
                $quarterStart = $this->getCurrentQuarterStartDate($currentDate);
                $quarterEnd = $this->getCurrentQuarterEndDate($currentDate);
                $currentCount = $this->salesTrackRepository->busnessColseSalesTrackCount($this->businessId, $quarterStart, $quarterEnd);
                $target = $this->targetRepository->getRangeTarget($this->user->id, $quarterStart, $quarterEnd, 'units_sold');
            } else if ($filter == 'yearly') {
                $yearStart = $this->getCurrentYearStartDate($currentDate);
                $yearEnd = $this->getCurrentYearEndDate($currentDate);
                $currentCount = $this->salesTrackRepository->busnessColseSalesTrackCount($this->businessId, $yearStart, $yearEnd);
                $target = $this->targetRepository->getRangeTarget($this->user->id, $yearStart, $yearEnd, 'units_sold');
            }
            if ($target) {
                $percentage = ($currentCount * 100) / $target;
            }
            return [
                'target' => number_format((float) $target, 2),
                'current_count' => number_format((float) $currentCount, 2),
                'percentage' => number_format((float) $percentage, 2),
            ];
        } catch (Exception $e) {
            Log::error('SalesTrackService::adminUnitesStatus', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * agentUnitesStatus
     * @param string $filter
     * @return array{current_count: string, percentage: string, target: string}
     */
    private function agentUnitesStatus(string $filter)
    {
        try {
            $currentDate = Carbon::now();
            $currentCount = null;
            $target = null;
            $percentage = null;
            if ($filter == 'monthly') {
                $startOfMonth = $this->getStartOfMonth($currentDate);
                $endOfMonth = $currentDate->endOfMonth();
                $currentCount = $this->salesTrackRepository->agentColseSalesTrackCount($this->businessId, $startOfMonth, $endOfMonth);
                $target = $this->targetRepository->getRangeTarget($this->user->id, $startOfMonth, $endOfMonth, 'units_sold');
            } else if ($filter == 'quarterly') {
                // Determine the start and end of the current quarter
                $quarterStart = $this->getCurrentQuarterStartDate($currentDate);
                $quarterEnd = $this->getCurrentQuarterEndDate($currentDate);
                $currentCount = $this->salesTrackRepository->agentColseSalesTrackCount($this->businessId, $quarterStart, $quarterEnd);
                $target = $this->targetRepository->getRangeTarget($this->user->id, $quarterStart, $quarterEnd, 'units_sold');
            } else if ($filter == 'yearly') {
                $yearStart = $this->getCurrentYearStartDate($currentDate);
                $yearEnd = $this->getCurrentYearEndDate($currentDate);
                $currentCount = $this->salesTrackRepository->agentColseSalesTrackCount($this->businessId, $yearStart, $yearEnd);
                $target = $this->targetRepository->getRangeTarget($this->user->id, $yearStart, $yearEnd, 'units_sold');
            }
            if ($target) {
                $percentage = ($currentCount * 100) / $target;
            }
            return [
                'target' => number_format((float) $target, 2),
                'current_count' => number_format((float) $currentCount, 2),
                'percentage' => number_format((float) $percentage, 2),
            ];
        } catch (Exception $e) {
            Log::error('SalesTrackService::agentUnitesStatus', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    /**
     * bulkDestory
     * @param array $ids
     */
    public function bulkDestory(array $ids)
    {
        try {
            return $this->salesTrackRepository->bulkDelete($ids);
        } catch (Exception $e) {
            Log::error('SalesTrackService:bulkDestory', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
