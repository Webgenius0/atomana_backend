<?php

namespace App\Repositories\API\V1\Target;

use App\Models\Target;
use Exception;
use Illuminate\Support\Facades\Log;

class TargetRepository implements TargetRepositoryInterface
{

    /**
     * storeTarget
     * @param array $credentials
     * @param int $userId
     * @return Target
     */
    public function storeTarget(array $credentials, int $userId): Target
    {
        try {
            return Target::create([
                'user_id' => $userId,
                'month'   => $credentials['month'],
                'amount'  => $credentials['amount'],
                'for'     => $credentials['for'],
            ]);
        } catch (Exception $e) {
            Log::error('App\Repositories\API\V1\Target\TargetRepository::storeTarget', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    /**
     * getRangeTarget
     * @param int $userId
     * @param string $startMonth
     * @param string $endMonth
     * @param string $for
     * @return mixed
     */
    public function getRangeTarget(int $userId, string $startMonth, string $endMonth, string $for): mixed
    {
        try {
            return Target::where('user_id', $userId)
                ->whereBetween('month', [$startMonth, $endMonth])
                ->where('for', $for)
                ->sum('amount');
        } catch (Exception $e) {
            Log::error('App\Repositories\API\V1\Target\TargetRepository::getRangeTarget', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
