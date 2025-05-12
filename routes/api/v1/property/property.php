<?php

use App\Http\Controllers\API\V1\Property\AccessInstruction\AccessInstructionController;
use App\Http\Controllers\API\V1\Property\PropertyController;
use App\Http\Controllers\API\V1\Property\Source\PropertySourceController;
use App\Http\Controllers\API\V1\Property\Type\PropertyTypeController;
use Illuminate\Support\Facades\Route;

// all profile route of property
Route::prefix('v1/property')->name('property.')->middleware(['auth:api', 'verified',])->group(function () {
    // routes for bouth admin and agents
    Route::middleware(['authorized'])->controller(PropertyController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store');
        Route::get('/dropdown', 'dropdown');
        Route::get('/show/{propertyId}', 'show');
        Route::get('/show/{propertyId}', 'show');

        Route::delete('/', 'bulkDelete');
    });

    Route::middleware(['authorized'])->controller(PropertySourceController::class)->group(function () {
        Route::get('/source', 'index');
    });

    Route::middleware(['authorized'])->controller(PropertyTypeController::class)->group(function () {
        Route::get('/type', 'index');
    });

    Route::middleware(['authorized'])->controller(AccessInstructionController::class)->group(function () {
        Route::get('/access-instruction', 'index');
        Route::post('/access-instruction', 'store');
        Route::get('/access-instruction/{propertyAccessInstruction}', 'show');
        Route::delete('/access-instruction', 'bulkDelete');
    });
});
