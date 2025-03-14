<?php

namespace App\Services\API\V1\VendorReview;

use App\Models\VendorReview;
use App\Repositories\API\V1\VendorReview\VendorReviewRepositoryInterface;
use App\Traits\V1\DateManager;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class VendorReviewService
{
    use DateManager;

    public $user;
    public $businessId;
    public $vendorReviewRepository;

    public function __construct(VendorReviewRepositoryInterface $vendorReviewRepository)
    {
        $this->user = Auth::user();
        $this->businessId = Auth::user()->business()->id;
        $this->vendorReviewRepository = $vendorReviewRepository;
    }
    /**
     * Get all reviews for the given vendor slug.
     *
     * @param string $vendorSlug
     * @return mixed
     * @throws \Exception
     */
    public function getReviewsByVendorSlug(string $vendorSlug): mixed
    {
        try {
            return $this->vendorReviewRepository->getReviewsByVendorSlug($vendorSlug);
        } catch (Exception $e) {
            Log::error('VendorReviewService::getReviewsByVendorSlug', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Store a newly created vendor review in storage.
     *
     * @param  array  $validatedData
     * @return \App\Models\VendorReview
     * @throws \Exception
     */
    public function storeReview(array $validatedData): VendorReview
    {
        try {
            $validatedData['user_id'] = $this->user->id;
            return $this->vendorReviewRepository->storeReview($validatedData);
        } catch (Exception $e) {
            Log::error('VendorReviewService::storeReview', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
