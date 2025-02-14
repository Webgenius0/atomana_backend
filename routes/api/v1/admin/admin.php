<?php

use App\Http\Controllers\API\V1\Admin\AgentController;
use Illuminate\Support\Facades\Route;

//routes for bouth admin
Route::prefix('v1/admin')->name('admin.')->middleware(['auth:api', 'verified', 'admin'])->group(function () {
    Route::prefix('/agent')->name('agent.')->controller(AgentController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });
});
