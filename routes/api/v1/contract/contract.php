<?php

use App\Http\Controllers\API\V1\Contract\ContractController;
use Illuminate\Support\Facades\Route;

// all profile route of expense for bouth admin and agents
Route::prefix('v1/contract')->middleware(['auth:api', 'verified', 'authorized'])->group(function () {
    // routes for ExpenseType controller
    Route::controller(ContractController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{contract}', 'show');
        Route::post('/', 'store');
        Route::delete('/', 'bulkDelete');
    });
});
