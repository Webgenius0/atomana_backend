<?php
    
namespace App\Services\API\V1\VendorCategory;

use App\Models\SalesTrack;
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
        $this->user                 = Auth::user();
        $this->businessId           = Auth::user()->business()->id;
        $this->vendorCategoryRepository = $vendorCategoryRepository;
    }

    /**
     * get Sales Track
     */
    public function getVendorCategory()
    {
        try {
            $perPage = request()->query('per_page', 25);
            return $this->vendorCategoryRepository->getSalesTrackByBusiness($this->businessId, $perPage);
        } catch (Exception $e) {
            Log::error('SalesTrackService::getSalesTrack', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * store Sales Track
     * @param array $credentials
     * @return SalesTrack
     */
    public function storeSalesTrack(array $credentials): SalesTrack
    {
        try {
            return $this->salesTrackRepository->create($credentials, $this->businessId);
        } catch (Exception $e) {
            Log::error('SalesTrackService::storeSalesTrack', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

}
