<?php

use App\Http\Controllers\API\V1\Property\PropertyController;
use Illuminate\Support\Facades\Route;

// all profile route of property
Route::prefix('v1/property')->name('property.')->middleware(['auth:api', 'verified',])->group(function () {
    // routes for bouth admin and agents
    Route::middleware(['agent'])->controller(PropertyController::class)->group(function () {
        Route::post('/store', 'store')->name('show');
    });
});
