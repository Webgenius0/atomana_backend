<?php

namespace App\Services\API\V1\VendorCategory;

use App\Helpers\Helper;
use App\Models\SalesTrack;
use App\Models\VendorCategory;
use App\Repositories\API\V1\SalesTrack\SalesTrackRepositoryInterface;
use App\Repositories\API\V1\Target\TargetRepositoryInterface;
use App\Repositories\API\V1\VendorCategory\VendorCategoryRepositoryInterface;
use App\Traits\V1\DateManager;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VendorCategoryService
{
    use DateManager;
    protected $user;
    protected $businessId;
    protected VendorCategoryRepositoryInterface $vendorCategoryRepository;

    /**
     * construct
     * @param \App\Repositories\API\V1\VendorCategory\VendorCategoryRepositoryInterface $vendorCategoryRepository
     */
    public function __construct(VendorCategoryRepositoryInterface $vendorCategoryRepository)
    {
        $this->user = Auth::user();
        $this->businessId = Auth::user()->business()->id;
        $this->vendorCategoryRepository = $vendorCategoryRepository;
    }

 
    /**
     * Get all vendor categories.
     *
     * @return mixed
     */
    public function getVendorCategory(): mixed
    {
        try {
            $perPage = request()->query('per_page', 25);
            return $this->vendorCategoryRepository->getAllVendorCategories($perPage);
        } catch (Exception $e) {
            Log::error('VendorCategoryService::getVendorCategory', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * store vendor category
     * @param array $categories
     * @return VendorCategory
     */
    public function storeVendorCategory(array $categories): VendorCategory
    {
        try {
            if (isset($categories['icon']) && $categories['icon'] instanceof \Illuminate\Http\UploadedFile) {
                $categories['icon'] = Helper::uploadFile($categories['icon'], 'vendor_categories');
            }
            return $this->vendorCategoryRepository->create($categories, $this->businessId);
        } catch (Exception $e) {
            Log::error('VendorCategoryService::storeVendorCategory', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Retrieve a vendor category by its ID.
     *
     * @param string $categorySlug The ID of the vendor category to retrieve.
     * @return VendorCategory The vendor category corresponding to the provided ID.
     * @throws Exception If an error occurs during retrieval.
     */
    public function getVendorCategoryBySlug(string $categorySlug): VendorCategory
    {
        try {
            return $this->vendorCategoryRepository->getVendorCategoryBySlug($categorySlug);
        } catch (Exception $e) {
            Log::error('VendorCategoryService::getVendorCategory', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
