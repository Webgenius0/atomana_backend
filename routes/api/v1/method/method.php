<?php

use App\Http\Controllers\API\V1\Method\PaymentMethodController;
use Illuminate\Support\Facades\Route;

// all profile route of expense for bouth admin and agents
Route::prefix('v1/method')->name('method.')->middleware(['auth:api', 'authorized'])->group(function () {
    // routes for ExpenseType controller
    Route::prefix('/payment')->name('payment.')->controller(PaymentMethodController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });
});
