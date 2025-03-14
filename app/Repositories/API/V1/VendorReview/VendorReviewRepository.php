<?php

namespace App\Repositories\API\V1\VendorReview;

use App\Models\Vendor;
use App\Models\VendorReview;
use Exception;
use Illuminate\Support\Facades\Log;

class VendorReviewRepository implements VendorReviewRepositoryInterface
{
    /**
     * Get all reviews for the given vendor slug.
     *
     * @param string $vendorSlug
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public function getReviewsByVendorSlug($vendorSlug): mixed
    {
        try {
            $reviews = Vendor::where('slug', $vendorSlug)
                ->with(['reviews:id,vendor_id,user_id,comment,created_at'])
                ->firstOrFail();
            return $reviews->reviews;
        } catch (Exception $e) {
            Log::error('VendorReviewRepository::getReviewsByVendorSlug', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    /**
     * Store a newly created vendor review in storage.
     *
     * @param  array  $validatedData
     * @return mixed
     * @throws \Exception
     */
    public function storeReview(array $validatedData): mixed
    {
        try {
            return VendorReview::create($validatedData);
        } catch (Exception $e) {
            Log::error('VendorReviewRepository::storeReview', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
