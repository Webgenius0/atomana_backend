<?php

namespace App\Http\Controllers\API\V1\Expense\Vendor;

use App\Http\Controllers\Controller;
use App\Services\API\V1\Expense\Vendor\VendorService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class VendorController extends Controller
{
    use ApiResponse;

    protected VendorService $vendorService;

    /**
     * construct
     * @param \App\Services\API\V1\Expense\Vendor\VendorService $vendorService
     */
    public function __construct(VendorService $vendorService)
    {
        $this->vendorService = $vendorService;
    }

    /**
     * index of vendors
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $response = $this->vendorService->getVendorsIndex();
            return $this->success(200, 'All Vendors', $response);
        } catch (Exception $e) {
            Log::error('VendorController::index', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
