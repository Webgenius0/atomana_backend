<?php

use App\Http\Controllers\API\V1\OpenHouse\FeedbackController;
use App\Http\Controllers\API\V1\OpenHouse\OpenHouseController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/open-house')->name('open.house.')->middleware(['auth:api', 'verified', 'authorized'])
    ->controller(OpenHouseController::class)->group(function () {
        Route::post('/store', 'store')->name('store');
    });


Route::prefix('v1/open-house/feedback')->name('open.house.')->middleware(['auth:api', 'verified', 'authorized'])
    ->controller(FeedbackController::class)->group(function () {
        Route::post('/store', 'store')->name('store');
    });
