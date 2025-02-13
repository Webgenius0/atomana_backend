<?php

namespace App\Repositories\API\V1\Expense\Vendor;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Collection;

interface VendorRepositoryInterface
{
    /**
     * gets all the data form the vendor table
     * @return \Illuminate\Database\Eloquent\Collection<int, Vendor>
     */
    public function getVendors(): Collection;
}
