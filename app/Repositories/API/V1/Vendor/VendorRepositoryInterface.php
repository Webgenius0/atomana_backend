<?php

namespace App\Repositories\API\V1\Vendor;

interface VendorRepositoryInterface
{
    /**
     * Get all vendor categories
     * @param int $perPage
     * @return mixed
     */
    public function getVendors(int $perPage = 25): mixed;

    /**
     * Get all vendor categories
     * @param int $perPage
     * @return mixed
     */
    public function getVendorsByCategory($categoryId, int $perPage = 25): mixed;

    /**
     * Get vendor by slug.
     *
     * @param string $VendorSlug Vendor slug.
     * @return mixed
     */
    public function getVendorBySlug($VendorSlug): mixed;

    /**
     * Store a newly created vendor in storage.
     *
     * @param  array  $vendor
     * @param  int  $businessId
     * @return mixed
     */
    public function storeVendor(array $vendor, int $businessId): mixed;
}
