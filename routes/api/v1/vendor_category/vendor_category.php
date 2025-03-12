<?php
use App\Http\Controllers\API\V1\VendorCategory\VendorCategoryController;
use Illuminate\Support\Facades\Route;

// all vendor category route of vendor
Route::prefix('v1/vendor-category')->name('vendor-category.')->middleware(['auth:api', 'verified',])->group(function () {
    Route::middleware(['authorized'])->controller(VendorCategoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
    });
});


