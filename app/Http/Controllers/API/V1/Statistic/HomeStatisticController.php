<?php

namespace App\Http\Controllers\API\V1\Statistic;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Statistic\LeaderboardResource;
use App\Services\API\V1\Expense\ExpenseService;
use App\Services\API\V1\SalesTrack\SalesTrackService;
use App\Services\API\V1\User\UserService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeStatisticController extends Controller
{
    protected SalesTrackService $salesTrackService;
    protected ExpenseService $expenseService;

    protected UserService $userService;
    /**
     * Summary of __construct
     * @param \App\Services\API\V1\SalesTrack\SalesTrackService $salesTrackService
     */
    public function __construct(SalesTrackService $salesTrackService, ExpenseService $expenseService, UserService $userService)
    {
        $this->salesTrackService = $salesTrackService;
        $this->expenseService = $expenseService;
        $this->userService = $userService;
    }


    /**
     * currentSales based on the filter
     * @param string $filter filter operation monthly|quarterly|yearly
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentSales(string $filter): JsonResponse
    {
        try {
            $response = $this->salesTrackService->currentSalesStatistics($filter);
            return $this->success(200, 'Current Sales', $response);
        } catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\Statistics\HomeStatisticController::currentSales', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }


    /**
     * unitsSold
     * @param string $filter
     * @return JsonResponse
     */
    public function unitsSold(string $filter): JsonResponse
    {
        try {
            $response = $this->salesTrackService->uniteSoldStatistics($filter);
            return $this->success(200, 'Current Sales', $response);
        } catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\Statistics\HomeStatisticController::currentSales', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * expenses
     * @param string $filter
     * @return JsonResponse
     */
    public function expenses(string $filter): JsonResponse
    {
        try {
            $response = $this->expenseService->expenseStatistics($filter);
            return $this->success(200, 'Current Sales', $response);
        } catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\Statistics\HomeStatisticController::expenses', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * netProfit
     * @param string $filter
     * @return JsonResponse
     */
    public function netProfit(string $filter): JsonResponse
    {
        try {
            $response = $this->expenseService->netProfitStatistics($filter);
            return $this->success(200, 'Net Profit', $response);
        } catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\Statistics\HomeStatisticController::expenses', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }



    /**
     * Summary of topAgents
     * @param string $sortedBy
     * @param string $filter
     * @return JsonResponse
     */
    public function leaderboard(string $sortedBy, string $filter): JsonResponse
    {
        try {
            $response = $this->salesTrackService->leaderboardAgents($sortedBy, $filter);
            return $this->success(200, 'Top agents on leaderboard.', new LeaderboardResource($response));
            // return $this->success(200, 'Top agents on leaderboard.', $response);
        } catch (Exception $e) {
            Log::error('UserController::topAgents', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * agentData
     * @param int $userId
     * @param string $filter
     * @return JsonResponse
     */
    public function agentData(int $userId, string $filter): JsonResponse
    {
        try {
            $response = $this->salesTrackService->agentSalesData($userId, $filter);
            return $this->success(200, 'Agent sales data.', $response);
        } catch (Exception $e) {
            Log::error('UserController::agentData', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
