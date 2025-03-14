<?php
use App\Http\Controllers\API\V1\VendorReview\VendorReviewController;
use Illuminate\Support\Facades\Route;

// all vendor review route of vendor
Route::prefix('v1/vendor-review')->name('vendor-review.')->middleware(['auth:api', 'verified',])->group(function () {
    Route::middleware(['authorized'])->controller(VendorReviewController::class)->group(function () {
        // Route::get('/', 'single')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('/single/{vendrSlug}', 'show')->name('show');
    });
});


