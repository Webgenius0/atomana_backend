<?php

use App\Http\Controllers\API\V1\Property\PropertyController;
use App\Http\Controllers\API\V1\Property\Source\PropertySourceController;
use Illuminate\Support\Facades\Route;

// all profile route of property
Route::prefix('v1/property')->name('property.')->middleware(['auth:api', 'verified',])->group(function () {
    // routes for bouth admin and agents
    Route::middleware(['authorized'])->controller(PropertyController::class)->group(function () {
        Route::post('/store', 'store')->name('show');
    });


    Route::middleware(['authorized'])->controller(PropertyController::class)->group(function () {
        Route::get('/dropdown', 'dropdown')->name('dropdown');
    });

    Route::middleware(['authorized'])->controller(PropertySourceController::class)->group(function () {
        Route::get('/source', 'index')->name('source.index');
    });
});
