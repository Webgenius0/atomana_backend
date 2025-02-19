<?php

namespace App\Repositories\API\V1\SalesTrake;

use App\Models\SalesTrack;
use Exception;
use Illuminate\Support\Facades\Log;

class SalesTrackRepository implements SalesTrackRepositoryInterface
{
    public function create(array $credentials): SalesTrack
    {
        try {
            return SalesTrack::create([
                'user_id' => $credentials['user_id'],
                'property_id' => $credentials['property_id'],
                'price' => $credentials['price'],
                'status' => $credentials['status'],
                'note' => $credentials['note'],
            ]);
        } catch(Exception $e) {
            Log::error('SalesTrakeRepository::create', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
