<?php

namespace App\Repositories\API\V1\VendorCategory;

use App\Models\VendorCategory;


interface VendorCategoryRepositoryInterface
{
    /**
     * Get all vendor categories.
     * @param int $perPage
     * @return mixed
     */
    public function getAllVendorCategories(int $perPage = 25);

    /**
     * Get vendor category by ID.
     * @param int $categoryId
     * @return VendorCategory
     */
    public function getVendorCategoryById(int $categoryId): VendorCategory;

    /**
     * Create a new vendor category.
     * @param array $credentials
     * @return VendorCategory
     */
    public function create(array $credentials): VendorCategory;

    /**
     * Update an existing vendor category.
     * @param int $categoryId
     * @param array $credentials
     * @return VendorCategory
     */
    public function update(int $categoryId, array $credentials): VendorCategory;

    /**
     * Delete a vendor category by ID.
     * @param int $categoryId
     * @return bool
     */
    public function delete(int $categoryId): bool;

    /**
     * Get vendor categories by business ID.
     * @param int $businessId
     * @param int $perPage
     * @return mixed
     */
    public function getVendorCategoriesByBusiness(int $businessId, int $perPage = 25);
}
