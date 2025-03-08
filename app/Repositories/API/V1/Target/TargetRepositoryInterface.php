<?php

namespace App\Repositories\API\V1\Target;

use App\Models\Target;

interface TargetRepositoryInterface
{

    /**
     * storeTarget
     * @param array $credentials
     * @param int $userId
     * @return Target
     */
    public function storeTarget(array $credentials, int $userId): Target;

    /**
     * getRangeTarget
     * @param int $userId
     * @param string $startMonth
     * @param string $endMonth
     * @param string $for
     * @return mixed
     */
    public function getRangeTarget(int $userId, string $startMonth, string $endMonth, string $for): mixed;
}
