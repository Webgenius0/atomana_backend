<?php

namespace App\Http\Controllers\API\V1\MyAgentEarning;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\AgentEarning\IndexResource;
use App\Services\API\V1\MyAgentEarning\MyAgentEarningService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MyAgentEarningController extends Controller
{
    protected MyAgentEarningService $myAgentEarningService;

    /**
     * construct
     * @param \App\Services\API\V1\MyAgentEarning\MyAgentEarningService $myAgentEarningService
     */
    public function __construct(MyAgentEarningService $myAgentEarningService)
    {
        $this->myAgentEarningService = $myAgentEarningService;
    }

    /**
     * index
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $response =  $this->myAgentEarningService->businessAgentEarning();
            return $this->success(200, 'Agents Earning', new IndexResource($response));
        }catch (Exception $e){
            Log::error('App\Services\API\V1\MyAgentEarning\MyAgentEarningService::index', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * search
     * @return JsonResponse
     */
    public function search(): JsonResponse
    {
        try {
            $response =  $this->myAgentEarningService->searchByName();
            return $this->success(200, 'Agents Earning', new IndexResource($response));
        }catch (Exception $e){
            Log::error('App\Services\API\V1\MyAgentEarning\MyAgentEarningService::search', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
