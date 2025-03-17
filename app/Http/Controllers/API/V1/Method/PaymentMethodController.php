<?php

namespace App\Http\Controllers\API\V1\Method;

use App\Http\Controllers\Controller;
use App\Services\API\V1\Method\PaymentMethodService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentMethodController extends Controller
{
    protected PaymentMethodService $payemntMethodService;

    public function __construct(PaymentMethodService $payemntMethodService)
    {
        $this->payemntMethodService = $payemntMethodService;
    }

    /**
     * index of categories
     * @return JsonResponse
     */
    public function index():JsonResponse
    {
        try {
            $response = $this->payemntMethodService->getPaymentMethod();
            return $this->success(200, 'All Payment Methods', $response);
        } catch (Exception $e) {
            Log::error('PaymentMethodController::index', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
