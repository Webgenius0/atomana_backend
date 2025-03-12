<?php
use App\Http\Controllers\API\V1\Vendor\VendorController;
use Illuminate\Support\Facades\Route;

// all vendor category route of vendor
Route::prefix('v1/vendor')->name('vendor.')->middleware(['auth:api', 'verified',])->group(function () {
    Route::middleware(['authorized'])->controller(VendorController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
    });
});


