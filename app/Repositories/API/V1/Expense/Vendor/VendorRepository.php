<?php

namespace App\Repositories\API\V1\Expense\Vendor;

use App\Models\Vendor;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class VendorRepository implements VendorRepositoryInterface
{
    /**
     * gets all the data form the vendor table
     * @return \Illuminate\Database\Eloquent\Collection<int, Vendor>
     */
    public function getVendors(): Collection
    {
        try {
            $types = Vendor::select('id', 'name')->get();
            return $types;
        }catch (Exception $e) {
            Log::error('VendorRepository::getVendors', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
