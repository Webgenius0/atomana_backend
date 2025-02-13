<?php

use App\Http\Controllers\API\V1\Expense\Catetory\ExpenseCategoryController;
use App\Http\Controllers\API\V1\Expense\ExpenseController;
use App\Http\Controllers\API\V1\Expense\SubCatetory\ExpenseSubCategoryController;
use App\Http\Controllers\API\V1\Expense\Type\ExpenseTypeController;
use App\Http\Controllers\API\V1\Expense\Vendor\VendorController;
use Illuminate\Support\Facades\Route;

// all profile route of expense for bouth admin and agents
Route::prefix('v1/expense')->name('expense.')->middleware(['auth:api', 'authorized'])->group(function () {
    // routes for ExpenseType controller
    Route::prefix('/type')->name('type.')->controller(ExpenseTypeController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });
    // routes for Expense Category controller
    Route::prefix('/category')->name('category.')->controller(ExpenseCategoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });
    // routes for Expense sub-category controller
    Route::prefix('/sub-category')->name('sub.category')->controller(ExpenseSubCategoryController::class)->group(function () {
        Route::get('/{expenseCategory}', 'index')->name('index');
    });
    // routes for Expense Vendor controller
    Route::prefix('/vendor')->name('vendor')->controller(VendorController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });



    // all route for expense
    Route::controller(ExpenseController::class)->group(function () {
        Route::post('/store/{expense_for}', 'store')->name('store');
        Route::get('/{expense_for}', 'index')->name('index');
    });
});
