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
    public function getVendors()
    {
        try {
            $perPage = request()->query('per_page', 25);
            return $this->vendorRepository->getVendors($perPage);
        } catch (Exception $e) {
            Log::error('VendorService::getVendors', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function getVendorBySlug($VendorSlug)
    {
        try {
            return $this->vendorRepository->getVendorBySlug($VendorSlug);
        } catch (Exception $e) {
            Log::error('VendorService::getVendorBySlug', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function storeVendor($validatedData)
    {
        try {
            return $this->vendorRepository->storeVendor($validatedData, $this->businessId);
        } catch (Exception $e) {
            Log::error('VendorService::storeVendor', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
