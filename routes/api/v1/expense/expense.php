<?php

use App\Http\Controllers\API\V1\Expense\Catetory\ExpenseCategoryController;
use App\Http\Controllers\API\V1\Expense\Type\ExpenseTypeController;
use Illuminate\Support\Facades\Route;

// all profile route of expense for bouth admin and agents
Route::prefix('v1/expense')->name('expense.')->middleware(['auth:api', 'authorized'])->group(function () {
    // routes for ExpenseType controller
    Route::prefix('/type')->name('type.')->controller(ExpenseTypeController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });
    // routes for ExpenseType controller
    Route::prefix('/category')->name('category.')->controller(ExpenseCategoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });
});
