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
                ->with(['business', 'category', 'reviews'])
                ->latest()->get();
            return $categories;
        } catch (Exception $e) {
            Log::error('VendorCategoryRepository::getVendors', ['error' => $e->getMessage()]);
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
            Log::error('VendorCategoryRepository::getVendorsByCategory', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Get vendor by slug.
     *
     * @param string $VendorSlug Vendor slug.
     * @return mixed
     */
    public function getVendorBySlug($VendorSlug): mixed
    {
        try {
            $vendor = Vendor::select('id', 'business_id', 'vendor_category_id', 'name', 'slug', 'website', 'email', 'phone', 'about', 'additional_note')
                ->with(['business', 'category:id,name,slug,icon', 'reviews'])->withCount('reviews')->where('slug', $VendorSlug)->firstOrFail($VendorSlug);
            return $vendor;
        } catch (Exception $e) {
            Log::error('VendorCategoryRepository::getVendorBySlug', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Store a newly created vendor in storage.
     *
     * @param  array  $vendor
     * @param  int  $businessId
     * @return mixed
     */
    public function storeVendor(array $vendor, int $businessId): mixed
    {
        try {
            $vendor = Vendor::create([
                'business_id' => $businessId,
                'vendor_category_id' => $vendor['vendor_category_id'],
                'name' => $vendor['name'],
                'slug' => Helper::generateUniqueSlug($vendor['name'], 'vendors'),
                'website' => $vendor['website'],
                'email' => $vendor['email'],
                'phone' => $vendor['phone'],
                'about' => $vendor['about'],
                'additional_note' => $vendor['additional_note'],
            ]);
            return $vendor;
        } catch (Exception $e) {
            Log::error('VendorCategoryRepository::storeVendor', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
