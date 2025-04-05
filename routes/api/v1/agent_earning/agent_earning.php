<?php

use App\Http\Controllers\API\V1\MyAgentEarning\MyAgentEarningController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1/agent-earning')->name('agent.earnings.')->middleware(['auth:api', 'verified', 'authorized'])->group(function () {

    Route::controller(MyAgentEarningController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/search', 'search')->name('search');
    });
});
