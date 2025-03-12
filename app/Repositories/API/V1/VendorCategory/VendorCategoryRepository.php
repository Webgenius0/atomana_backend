<?php
        
namespace App\Repositories\API\V1\VendorCategory;

use App\Models\VendorCategory;
use Exception;
use Illuminate\Support\Facades\Log;

class VendorCategoryRepository implements VendorCategoryRepositoryInterface
{
    /**
     * Get all vendor categories
     * @param int $perPage
     * @return mixed
     */
    public function getAllVendorCategories(int $perPage = 25)
    {
        try {
            return VendorCategory::orderBy('id', 'desc')->paginate($perPage);
        } catch (Exception $e) {
            Log::error('VendorCategoryRepository::getAllVendorCategories', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Get vendor category by ID
     * @param int $categoryId
     * @return VendorCategory
     */
    public function getVendorCategoryById(int $categoryId): VendorCategory
    {
        try {
            return VendorCategory::findOrFail($categoryId);
        } catch (Exception $e) {
            Log::error('VendorCategoryRepository::getVendorCategoryById', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Create a new vendor category
     * @param array $credentials
     * @return VendorCategory
     */
    public function create(array $credentials): VendorCategory
    {
        try {
            return VendorCategory::create([
                'name' => $credentials['name'],
                'description' => $credentials['description'],
                'status' => $credentials['status'],
            ]);
        } catch (Exception $e) {
            Log::error('VendorCategoryRepository::create', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Update an existing vendor category
     * @param int $categoryId
     * @param array $credentials
     * @return VendorCategory
     */
    public function update(int $categoryId, array $credentials): VendorCategory
    {
        try {
            $category = VendorCategory::findOrFail($categoryId);
            $category->update([
                'name' => $credentials['name'],
                'description' => $credentials['description'],
                'status' => $credentials['status'],
            ]);
            return $category;
        } catch (Exception $e) {
            Log::error('VendorCategoryRepository::update', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Delete a vendor category by ID
     * @param int $categoryId
     * @return bool
     */
    public function delete(int $categoryId): bool
    {
        try {
            $category = VendorCategory::findOrFail($categoryId);
            return $category->delete();
        } catch (Exception $e) {
            Log::error('VendorCategoryRepository::delete', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Get vendor categories by business ID
     * @param int $businessId
     * @param int $perPage
     * @return mixed
     */
    public function getVendorCategoriesByBusiness(int $businessId, int $perPage = 25)
    {
        try {
            return VendorCategory::where('business_id', $businessId)
                ->orderBy('id', 'desc')
                ->paginate($perPage);
        } catch (Exception $e) {
            Log::error('VendorCategoryRepository::getVendorCategoriesByBusiness', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
