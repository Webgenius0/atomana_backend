<?php

namespace App\Services\API\V1\Expense\Vendor;

use App\Repositories\API\V1\Expense\Vendor\VendorRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class VendorService extends VendorRepository
{
    /**
     * get data from Vendor Repo
     * @return \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vendor>
     */
    public function getVendorsIndex():mixed
    {
        try {
            $data = $this->getVendors();
            return $data;
        } catch (Exception $e) {
            Log::error('VendorService::getTypes', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
