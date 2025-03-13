<?php

namespace App\Repositories\API\V1\Vendor;

use App\Models\Vendor;
use App\Helpers\Helper;
use Exception;
use Illuminate\Support\Facades\Log;

class VendorRepository implements VendorRepositoryInterface
{

    /**
     * Get all vendor categories
     * @param int $perPage
     * @return mixed
     */
    public function getVendors(int $perPage = 25): mixed
    {
        try {
            $categories = Vendor::select('id', 'business_id', 'vendor_category_id', 'name', 'slug', 'website', 'email', 'phone', 'about')
                ->with(['business:id,name,slug', 'vendorCategory:id,name,slug', 'reviews:id,vendor_id,rating,comment'])
                ->latest()->get();
            return $categories;
        } catch (Exception $e) {
            Log::error('VendorCategoryRepository::getAllVendorCategories', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
    /**
     * Get all vendor categories
     * @param int $perPage
     * @return mixed
     */
    public function getVendorsByCategory($categoryId, int $perPage = 25): mixed
    {
        try {
            $categories = Vendor::select('id', 'business_id', 'vendor_category_id', 'name', 'slug', 'website', 'email', 'phone', 'about')
                ->with(['business:id,name,slug', 'vendorCategory:id,name,slug', 'reviews:id,vendor_id,rating,comment'])->where('vendor_category_id', $categoryId)
                ->latest()->get();
            return $categories;
        } catch (Exception $e) {
            Log::error('VendorCategoryRepository::getAllVendorCategories', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function getVendorBySlug($VendorSlug): mixed
    {
        try {
            $vendor = Vendor::select('id', 'business_id', 'vendor_category_id', 'name', 'slug', 'website', 'email', 'phone', 'about')
                ->with(['business:id,name,slug', 'vendorCategory:id,name,slug', 'reviews:id,vendor_id,rating,comment'])->where('slug', $VendorSlug)->firstOrFail($VendorSlug);
            return $vendor;
        } catch (Exception $e) {
            Log::error('VendorCategoryRepository::getAllVendorCategories', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
