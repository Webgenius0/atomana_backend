<?php

namespace App\Services\API\V1\Vendor;

use App\Helpers\Helper;
use App\Models\SalesTrack;
use App\Models\VendorCategory;
use App\Repositories\API\V1\SalesTrack\SalesTrackRepositoryInterface;
use App\Repositories\API\V1\Target\TargetRepositoryInterface;
use App\Repositories\API\V1\Vendor\VendorRepository;
use App\Repositories\API\V1\Vendor\VendorRepositoryInterface;
use App\Repositories\API\V1\VendorCategory\VendorCategoryRepositoryInterface;
use App\Traits\V1\DateManager;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VendorService
{
    use DateManager;
    protected $user;
    protected $businessId;
    protected VendorRepositoryInterface $vendorRepository;

    /**
     * construct
     * @param \App\Repositories\API\V1\Vendor\VendorRepositoryInterface $vendorRepository
     */
    public function __construct(VendorRepositoryInterface $vendorRepository)
    {
        $this->user = Auth::user();
        $this->businessId = Auth::user()->business()->id;
        $this->vendorRepository = $vendorRepository;
    }
    /**
     * Retrieve a paginated list of vendors.
     *
     * @return mixed
     * @throws \Exception
     */
    public function getVendors(): mixed
    {
        try {
            $perPage = request()->query('per_page', 25);
            return $this->vendorRepository->getVendors($perPage);
        } catch (Exception $e) {
            Log::error('VendorService::getVendors', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Get vendor by slug.
     *
     * @param string $VendorSlug Vendor slug.
     * @return mixed
     * @throws \Exception
     */
    public function getVendorBySlug(string $VendorSlug): mixed
    {
        try {
            return $this->vendorRepository->getVendorBySlug($VendorSlug);
        } catch (Exception $e) {
            Log::error('VendorService::getVendorBySlug', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Store a newly created vendor in storage.
     *
     * @param  array  $validatedData
     * @return mixed
     * @throws \Exception
     */
    public function storeVendor(array $validatedData): mixed
    {
        try {
            return $this->vendorRepository->storeVendor($validatedData, $this->businessId);
        } catch (Exception $e) {
            Log::error('VendorService::storeVendor', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
