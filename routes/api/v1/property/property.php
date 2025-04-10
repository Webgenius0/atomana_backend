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
        Route::post('/store', 'store')->name('show');
    });


    Route::middleware(['authorized'])->controller(PropertyController::class)->group(function () {
        Route::get('/dropdown', 'dropdown')->name('dropdown');
    });

    Route::middleware(['authorized'])->controller(PropertySourceController::class)->group(function () {
        Route::get('/source', 'index')->name('source.index');
    });

    Route::middleware(['authorized'])->controller(PropertyTypeController::class)->group(function () {
        Route::get('/type', 'index')->name('type.index');
    });

    Route::middleware(['authorized'])->controller(AccessInstructionController::class)->group(function () {
        Route::get('/access-instruction', 'index')->name('access.instruction.index');
        Route::post('/access-instruction', 'store')->name('access.instruction.store');
        Route::get('/access-instruction/{propertyAccessInstruction}', 'show')->name('access.instruction.show');
    });
});
