<?php

use App\Http\Controllers\API\V1\Profile\TargetController;
use Illuminate\Support\Facades\Route;

// all profile route of sales track
Route::prefix('v1/profile/target')->name('profile.target.')->middleware(['auth:api', 'verified',])->group(function () {
    Route::middleware(['authorized'])->controller(TargetController::class)->group(function () {
        Route::post('/', 'store')->name('store');
    });
});
