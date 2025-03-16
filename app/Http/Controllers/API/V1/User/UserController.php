<?php

namespace App\Http\Controllers\API\V1\User;

use App\Http\Controllers\Controller;
use App\Services\API\V1\User\UserService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected UserService $userService;

    /**
     * construct
     * @param \App\Services\API\V1\User\UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * User data for the landing page.
     * @return \Illuminate\Http\JsonResponse
     */
    public function userData(): JsonResponse
    {
        try {
            $response = $this->userService->data();
            return $this->success(200, 'User data fetched successfully', $response);
        }catch(Exception $e) {
            Log::error('UserController::data', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
