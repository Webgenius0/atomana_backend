<?php

namespace App\Http\Controllers\API\V1\Profile;

use App\Http\Controllers\Controller;
use App\Services\API\V1\Profile\ProfileService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    use ApiResponse;
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show():JsonResponse
    {
        try{
            return $this->success();
        }catch(Exception $e) {
            Log::error('ProfileController::show', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    public function update():JsonResponse
    {
        try{
            return $this->success();
        }catch(Exception $e) {
            Log::error('ProfileController::update', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    public function destory():JsonResponse
    {
        try{
            return $this->success();
        }catch(Exception $e) {
            Log::error('ProfileController::destory', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
