<?php

namespace App\Services\API\V1\MyAgentEarning;

use App\Repositories\API\V1\SalesTrack\SalesTrackRepositoryInterface;
use App\Repositories\API\V1\UserYTC\UserYTCRepositoryInterface;

class MyAgentEarningService
{
    protected UserYTCRepositoryInterface $userYTCRepository;
    protected SalesTrackRepositoryInterface $salesTrackRepository;

    /**
     * construct
     * @param \App\Repositories\API\V1\UserYTC\UserYTCRepositoryInterface $userYTCRepository
     * @param \App\Repositories\API\V1\SalesTrack\SalesTrackRepositoryInterface $salesTrackRepository
     */
    public function __construct(UserYTCRepositoryInterface $userYTCRepository, SalesTrackRepositoryInterface $salesTrackRepository)
    {
        $this->userYTCRepository = $userYTCRepository;
        $this->salesTrackRepository = $salesTrackRepository;
    }



}
