<?php

use App\Http\Controllers\API\V1\User\AgentController;
use Illuminate\Support\Facades\Route;

// all profile route of profile
Route::prefix('v1/user')->name('user.')->middleware(['auth:api', 'verified',])->group(function () {
    // routes for bouth admin and agents
    Route::prefix('/agent')->name('agent.')->middleware(['authorized'])
    ->controller(AgentController::class)->group(function () {
        Route::get('/get-agent', 'getAgent')->name('get-agent');
    });
});
