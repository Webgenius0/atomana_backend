<?php

namespace App\Http\Controllers\API\V1\OpenHouse;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\OpenHouse\CreateFeedbackRequest;
use App\Http\Resources\API\V1\OpenHouse\CreateFeedback;
use App\Services\API\V1\OpenHouse\OpenHouseFeedbackService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{
    use ApiResponse;
    protected OpenHouseFeedbackService $openHouseFeedbackService;

    /**
     * construct
     * @param \App\Services\API\V1\OpenHouse\OpenHouseFeedbackService $openHouseFeedbackService
     */
    public function __construct(OpenHouseFeedbackService $openHouseFeedbackService)
    {
        $this->openHouseFeedbackService = $openHouseFeedbackService;
    }


    public function index($openHouseid): JsonResponse
    {
        try {
            $response = $this->openHouseFeedbackService->getFeedbacksOfOpenHouse($openHouseid);
            return $this->success(200, 'List of Feedbacks', $response);
        }catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\FeedbackController::index', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }


    /**
     * store
     * @param \App\Http\Requests\API\V1\OpenHouse\CreateFeedbackRequest $createFeedbackRequest
     * @return JsonResponse
     */
    public function store(CreateFeedbackRequest $createFeedbackRequest): JsonResponse
    {
        try {
            $validatedData = $createFeedbackRequest->validated();
            $response = $this->openHouseFeedbackService->storeFeedback($validatedData);
            return $this->success(201, 'Open House Created Successfully', new CreateFeedback($response));
        }catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\FeedbackController::store', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
