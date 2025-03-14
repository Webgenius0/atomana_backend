<?php

namespace App\Repositories\API\V1\VendorReview;

interface VendorReviewRepositoryInterface
{
    /**
     * Get all reviews for the given vendor slug.
     *
     * @param string $vendorSlug
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public function getReviewsByVendorSlug(string $vendorSlug): mixed;

    /**
     * Store a newly created vendor review in storage.
     *
     * @param  array  $validatedData
     * @return mixed
     * @throws \Exception
     */
    public function storeReview(array $validatedData): mixed;
}
