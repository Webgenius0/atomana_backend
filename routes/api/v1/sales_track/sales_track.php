<?php

use App\Http\Controllers\API\V1\SalesTrack\SalesTrackController;
use Illuminate\Support\Facades\Route;


// all profile route of sales track
Route::prefix('v1/sales-track')->name('sales-track.')->middleware(['auth:api', 'verified',])->group(function () {
    Route::middleware(['authorized'])->controller(SalesTrackController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::delete('/', 'bulkDelete');
    });
});
