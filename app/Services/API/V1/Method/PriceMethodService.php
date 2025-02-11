<?php

namespace App\Services\API\V1\Method;

use App\Repositories\API\V1\Method\PaymentMethodRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class PriceMethodService
{
    protected PaymentMethodRepositoryInterface $paymentMethodRepository;

    /**
     * __construct
     * @param \App\Repositories\API\V1\Method\PaymentMethodRepositoryInterface $paymentMethodRepository
     */
    public function __construct(PaymentMethodRepositoryInterface $paymentMethodRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    /**
     * Summary of getPaymentMethod
     * @return \Illuminate\Database\Eloquent\Collection<int, \App\Models\PaymentMethod>
     */
    public function getPaymentMethod():mixed
    {
        try {
            $data = $this->paymentMethodRepository->getPaymentMethod();
            return $data;
        } catch (Exception $e) {
            Log::error('PriceMethodService::getPaymentMethod', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
