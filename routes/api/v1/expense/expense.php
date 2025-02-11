<?php

use App\Http\Controllers\API\V1\Expense\Type\ExpenseTypeController;
use Illuminate\Support\Facades\Route;

// all profile route of profile
Route::prefix('v1/expense')->name('expense.')->middleware(['auth:api', 'authorized'])->group(function () {
    // routes for bouth admin and agents EspenseType controller
    Route::prefix('/type')->name('type.')->controller(ExpenseTypeController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });
});
