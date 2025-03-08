<?php

namespace App\Repositories\API\V1\Target;

use App\Models\Target;

interface TargetRepositoryInterface
{
    /**
     * getMonthlyTarget
     * @param int $userId
     * @param string $month
     * @param string $for
     * @return Target|null
     */
    public function getMonthlyTarget(int $userId, string $month, string $for): Target|null;

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
