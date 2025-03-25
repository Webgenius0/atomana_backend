<?php

use App\Http\Controllers\API\V1\User\AgentController;
use App\Http\Controllers\API\V1\User\UserController;
use Illuminate\Support\Facades\Route;

// all profile route of profile
Route::prefix('v1/user')->name('user.')->middleware(['auth:api', 'verified',])->group(function () {

    // routes for bouth admin and agents
    Route::middleware(['authorized'])->group(function () {
        // landing page
        Route::get('/data', [UserController::class, 'userData'])->name('data');
        // dropdown
        Route::get('/agent/get-agent', [AgentController::class, 'getAgent'])->name('agent.get-agent');
        Route::get('/agent/co-list', [AgentController::class, 'getCoList'])->name('agent.co-list');
    });
});
