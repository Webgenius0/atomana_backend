<?php

namespace App\Http\Controllers\API\V1\Property\Type;

use App\Http\Controllers\Controller;
use App\Services\API\V1\Property\Type\PropertyTypeService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PropertyTypeController extends Controller
{
    private PropertyTypeService $propertyTypeService;

    /**
     * construct
     * @param \App\Services\API\V1\Property\Type\PropertyTypeService $propertyTypeService
     */
    public function __construct(PropertyTypeService $propertyTypeService)
    {
        $this->propertyTypeService = $propertyTypeService;
    }

    /**
     * index
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $response = $this->propertyTypeService->getDropdown();
            return $this->success(200, 'Property Index', $response);
        }catch (Exception $e) {
            Log::error('PropertyTypeController::index', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
