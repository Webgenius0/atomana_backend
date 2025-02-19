<?php

namespace App\Http\Controllers\API\V1\User;

use App\Http\Controllers\Controller;
use App\Services\API\V1\Admin\AgentService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AgentController extends Controller
{
    use ApiResponse;
    protected AgentService $agentService;

    /**
     * construct
     * @param \App\Services\API\V1\Admin\AgentService $agentService
     */
    public function __construct(AgentService $agentService)
    {
        $this->agentService = $agentService;
    }

    /**
     * agent Drop Down
     * @return \Illuminate\Http\JsonResponse
     */
    public function agentDropDown()
    {
        try {
            $response = $this->agentService->getAgents();
            return $this->success(200, 'Agent Id and Name', $response);
        } catch (Exception $e) {
            Log::error('AgentController::agentDropDown', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
