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
     * @param string $categorySlug
     * @return VendorCategory
     */
    public function getVendorCategoryBySlug(string $categorySlug): VendorCategory;

    /**
     * Create a new vendor category.
     * @param array $categories
     * @return mixed
     */
    public function create(array $categories, int $businessId): mixed;

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
