<?php

use App\Http\Controllers\API\V1\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

// all profile route of profile
Route::prefix('v1/profile')->name('profile.')->middleware(['auth:api'])->group(function () {

    // routes for bouth admin and agents
    Route::middleware(['authorized'])->controller(ProfileController::class)->group(function () {
        Route::get('/show', 'show')->name('show');
    });
});
