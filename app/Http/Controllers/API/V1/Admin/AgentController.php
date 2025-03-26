<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Admin\AgentProfileUpdateRequest;
use App\Http\Resources\API\V1\Admin\AgentIndexResource;
use App\Http\Resources\API\V1\Admin\AgentProfileShowResource;
use App\Models\User;
use App\Services\API\V1\Admin\AgentService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AgentController extends Controller
{
    private AgentService $agentService;

    public function __construct(AgentService $agentService)
    {
        $this->agentService = $agentService;
    }


    /**
     * Getting list of all agents of admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $response = $this->agentService->getAgents();
            return $this->success(200, 'Profile Data Seuccessfully Retrived', new AgentIndexResource($response));
        } catch (Exception $e) {
            Log::error('AgentController::index', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * show
     * @param \App\Models\User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        try {
            $resource =  $this->agentService->getAgentDetails($user);
            return $this->success(200, 'Agent Profile', new AgentProfileShowResource($resource));
        } catch (Exception $e) {
            Log::error('AgentController::show', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * update
     * @param \Illuminate\Http\Request $request
     * @param string $slug
     * @return JsonResponse
     */
    public function update(AgentProfileUpdateRequest $request, User $user): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $this->agentService->updateAgentProfile($user, $validatedData);
            return $this->success(200, 'Profile Updated Seuccessfully');
        } catch (Exception $e) {
            Log::error('AgentController::update', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
