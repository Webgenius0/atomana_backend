<?php

namespace App\Repositories\API\V1\SalesTrack;

use App\Models\SalesTrack;

interface SalesTrackRepositoryInterface
{
    public function create(array $credentials): SalesTrack;
}
