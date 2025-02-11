<?php

namespace App\Repositories\API\V1\Method;

use Illuminate\Database\Eloquent\Collection;

interface PaymentMethodRepositoryInterface
{
    /**
     * gets all payment methord
     * @return \Illuminate\Database\Eloquent\Collection<int, \App\Models\PaymentMethod>
     */
    public function getPaymentMethod():Collection;
}
