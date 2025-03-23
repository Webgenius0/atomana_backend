<?php

namespace App\Services\API\V1\MyAgentEarning;

use App\Repositories\API\V1\SalesTrack\SalesTrackRepositoryInterface;
use App\Repositories\API\V1\UserYTC\UserYTCRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MyAgentEarningService
{
    private UserYTCRepositoryInterface $userYTCRepository;
    private SalesTrackRepositoryInterface $salesTrackRepository;
    private $business;

    /**
     * construct
     * @param \App\Repositories\API\V1\UserYTC\UserYTCRepositoryInterface $userYTCRepository
     * @param \App\Repositories\API\V1\SalesTrack\SalesTrackRepositoryInterface $salesTrackRepository
     */
    public function __construct(UserYTCRepositoryInterface $userYTCRepository, SalesTrackRepositoryInterface $salesTrackRepository)
    {
        $this->userYTCRepository = $userYTCRepository;
        $this->salesTrackRepository = $salesTrackRepository;
        $this->business = Auth::user()->business();
    }

    public function getData()
    {
        try {
            
        }catch (Exception $e){
            Log::error("App\Services\API\V1\MyAgentEarning\MyAgentEarningService::getData". ['error' => $e->getMessage()]);
            throw $e;
        }
    }

}
