<?php

namespace App\Http\Controllers\API\V1\Property\Source;

use App\Http\Controllers\Controller;
use App\Services\API\V1\Property\PropertyService;
use App\Services\API\V1\Property\Source\PropertySourceService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PropertySourceController extends Controller
{
    protected  PropertySourceService $propertySourceService;

    /**
     * Summary of __construct
     * @param \App\Services\API\V1\Property\Source\PropertySourceService $propertySourceService
     */
    public function __construct(PropertySourceService $propertySourceService)
    {
        $this->propertySourceService = $propertySourceService;
    }


    /**
     * index
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $response = $this->propertySourceService->getIndex();
            return $this->success(200, 'Property Source List', $response);
        }catch (Exception $e) {
            Log::error('App\Http\Controllers\API\V1\Property\Source\PropertySourceController::index', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
