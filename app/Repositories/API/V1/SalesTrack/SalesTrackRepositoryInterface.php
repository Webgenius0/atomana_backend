<?php

namespace App\Repositories\API\V1\SalesTrake;

use App\Models\SalesTrack;

interface SalesTrackRepositoryInterface
{
    public function create(array $credentials): SalesTrack;
}
