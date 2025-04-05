<?php

namespace App\Services\API\V1\OpenHouse;

use App\Models\OpenHouseFeedback;
use App\Repositories\API\V1\OpenHouse\FeedbackRepositoryInterface;
use App\Repositories\API\V1\OpenHouse\OpenHouseRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OpenHouseFeedbackService
{
    protected OpenHouseRepositoryInterface $openHouseRepository;
    protected FeedbackRepositoryInterface $feedbackRepository;
    protected $userId;
    protected $businessId;

    /**
     * Summary of __construct
     * @param \App\Repositories\API\V1\OpenHouse\OpenHouseRepositoryInterface $openHouseRepository
     * @param \App\Repositories\API\V1\OpenHouse\FeedbackRepositoryInterface $feedbackRepository
     */
    public function __construct(OpenHouseRepositoryInterface $openHouseRepository, FeedbackRepositoryInterface $feedbackRepository)
    {
        $this->openHouseRepository = $openHouseRepository;
        $this->feedbackRepository = $feedbackRepository;
        $this->userId = Auth::user()->id;
        $this->businessId = Auth::user()->business()->id;
    }

    /**
     * storeFeedback
     * @param array $credentials
     * @return OpenHouseFeedback
     */
    public function storeFeedback(array $credentials): OpenHouseFeedback
    {
        try {
            $openHouse = $this->openHouseRepository->openHouseById($credentials['open_house_id']);
            return $this->feedbackRepository->createOpenHouseFeedback($credentials, $this->userId, $this->businessId, $openHouse->property_id);
        } catch (Exception $e) {
            Log::error('App\Services\API\V1\OpenHouse\OpenHouseFeedbackService:storeFeedback');
            throw $e;
        }
    }
}
