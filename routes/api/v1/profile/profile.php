<?php

use App\Http\Controllers\API\V1\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

// all profile route of profile
Route::prefix('/profile')->name('profile.')->middleware(['auth:api'])->group(function () {

    // routes for bouth admin and agents
    Route::middleware(['authorized'])->controller(ProfileController::class)->group(function () {
        Route::get('/show', 'show')->name('show');
    });
    // route for admin
    Route::middleware(['admin'])->group(function () {});
    // route for agent
    Route::middleware(['agent'])->group(function () {});
});
