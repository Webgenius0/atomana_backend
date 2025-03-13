<?php

namespace App\Repositories\API\V1\Vendor;

interface VendorRepositoryInterface
{
    public function getVendors(int $perPage = 25);

    public function getVendorsByCategory($categoryId, int $perPage = 25);

    public function getVendorBySlug($VendorSlug);

    // public function storeVendor(array $vendor, $businessId, $vendorId);
}
