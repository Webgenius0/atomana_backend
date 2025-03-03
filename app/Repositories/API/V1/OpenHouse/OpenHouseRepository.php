<?php

namespace App\Repositories\API\V1\OpenHouse;

use App\Models\OpenHouse;
use Exception;
use Illuminate\Support\Facades\Log;

class OpenHouseRepository implements OpenHouseRepositoryInterface
{
    /**
     * storeOpenHourse
     * @param array $credentials
     * @return OpenHouse
     */
    public function storeOpenHourse(array $credentials):OpenHouse
    {
        try {
            return OpenHouse::create([
                'business_id' => $credentials['business_id'],
                'email'       => $credentials['email'],
                'date'        => $credentials['date'],
                'start_time'  => $credentials['start_time'],
                'end_time'    => $credentials['end_time'],
                'wavy_man'    => $credentials['wavy_man'],
                'sign_number' => $credentials['sign_number'],
            ]);
        }catch(Exception $e) {
            Log::error('App\Repositories\API\V1\OpenHouse\OpenHouseRepository:storeOpenHourse');
            throw $e;
        }
    }
}
