<?php

namespace App\Repositories\API\V1\OpenHouse;

use App\Models\OpenHouse;

interface OpenHouseRepositoryInterface
{
    public function storeOpenHourse(array $credentials):OpenHouse;
}
