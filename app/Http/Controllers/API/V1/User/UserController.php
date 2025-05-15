<?php

namespace App\Http\Controllers\API\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\User\UpdatePassword;
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
            Log::error('UserController::userData', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * updatePassword
     * @param \App\Http\Requests\API\V1\User\UpdatePassword $updatePassword
     * @return JsonResponse
     */
    public function updatePassword(UpdatePassword $updatePassword): JsonResponse
    {
        try {
            $validatedData = $updatePassword->validated();
            $this->userService->updatePassword($validatedData);
            return $this->success(200, 'update successfull');
        }catch(Exception $e) {
            Log::error('UserController::updatePassword', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
