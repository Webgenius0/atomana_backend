<?php

namespace App\Http\Controllers\API\V1\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Profile\AddressRequest;
use App\Http\Requests\API\V1\Profile\SocialMediaRequest;
use App\Http\Resources\API\V1\Profile\ShowProfileResource;
use App\Services\API\V1\Profile\ProfileService;
use App\Traits\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * returning the profile of a user
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        try {
            $response = $this->profileService->getProfile();
            return $this->success(200, 'Profile Data Seuccessfully Retrived', new ShowProfileResource($response));
        } catch (Exception $e) {
            Log::error('ProfileController::show', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * update address
     * @return JsonResponse
     */
    public function address(AddressRequest $addressRequest): JsonResponse
    {
        try {
            $validatedData = $addressRequest->validated();
            $this->profileService->addressUpdateOperation($validatedData['address']);
            return $this->success(202	, 'updated successful');
        } catch (Exception $e) {
            Log::error('ProfileController::address', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * update phone
     * @return JsonResponse
     */
    public function phone(): JsonResponse
    {
        try {
            $this->profileService->phoneUpdateOperation();
            return $this->success(202	, 'updated successful');
        } catch (Exception $e) {
            Log::error('ProfileController::phone', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * update birthday
     * @return JsonResponse
     */
    public function birthday(): JsonResponse
    {
        try {
            $this->profileService->birthdayUpdateOperation();
            return $this->success(202	, 'updated successful');
        } catch (Exception $e) {
            Log::error('ProfileController::phone', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * update anniversaryHomeAddrress
     * @return JsonResponse
     */
    public function anniversaryHomeAddress(): JsonResponse
    {
        try {
            $this->profileService->anniversaryHomeAddrressUpdateOperation();
            return $this->success(202	, 'updated successful');
        } catch (Exception $e) {
            Log::error('ProfileController::phone', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }


    /**
     * socialMedia
     * @param \App\Http\Requests\API\V1\Profile\SocialMediaRequest $socialMediaRequest
     * @return JsonResponse
     */
    public function socialMedia(SocialMediaRequest $socialMediaRequest): JsonResponse
    {
        try {
            $validatedData = $socialMediaRequest->validated();
            Log::info($validatedData);
            $this->profileService->socialMediaUpdateOperation($validatedData);
            return $this->success(202	, 'updated successful');
        } catch (Exception $e) {
            Log::error('ProfileController::phone', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }

    /**
     * update about
     * @return JsonResponse
     */
    public function about(): JsonResponse
    {
        try {
            $this->profileService->aboutUpdateOperation();
            return $this->success(202	, 'updated successful');
        } catch (Exception $e) {
            Log::error('ProfileController::phone', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }



}
