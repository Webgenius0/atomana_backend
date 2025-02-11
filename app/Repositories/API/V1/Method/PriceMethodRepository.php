<?php

namespace App\Repositories\API\V1\Method;

use App\Models\PaymentMethod;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class PriceMethodRepository implements PriceMethodRepositoryInterface
{
    /**
     * gets all payment methord
     * @return \Illuminate\Database\Eloquent\Collection<int, \App\Models\PaymentMethod>
     */
    public function getPaymentMethod(): Collection
    {
        try {
            $categories = PaymentMethod::all();
            return $categories;
        } catch (Exception $e) {
            Log::error('PriceMethodRepository::getPaymentMethod', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
