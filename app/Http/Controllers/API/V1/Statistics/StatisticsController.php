<?php

namespace App\Http\Controllers\API\V1\Statistics;

use App\Http\Controllers\Controller;
use App\Services\API\V1\SalesTrack\SalesTrackService;
use App\Services\API\V1\Statistics\SalesService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StatisticsController extends Controller
{
    use ApiResponse;
    protected SalesTrackService $salesTrackService;

    /**
     * Summary of __construct
     * @param \App\Services\API\V1\SalesTrack\SalesTrackService $salesTrackService
     */
    public function __construct(SalesTrackService $salesTrackService)
    {
        $this->salesTrackService = $salesTrackService;
    }


    /**
     * currentSales based on the filter
     * @param string $filter filter operation [month, quarter,  year]
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentSales(string $filter): JsonResponse
    {
        try {
            $response = $this->salesTrackService->currentSalesStatistics($filter);
            return $this->success(200, 'Current Sales', $response);
        } catch(Exception $e) {
            Log::error('App\Http\Controllers\API\V1\Statistics\StatisticsController::currentSales', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
