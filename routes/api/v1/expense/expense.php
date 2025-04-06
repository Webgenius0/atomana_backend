<?php

use App\Http\Controllers\API\V1\Expense\Catetory\ExpenseCategoryController;
use App\Http\Controllers\API\V1\Expense\ExpenseController;
use App\Http\Controllers\API\V1\Expense\SubCatetory\ExpenseSubCategoryController;
use Illuminate\Support\Facades\Route;

// all profile route of expense for bouth admin and agents
Route::prefix('v1/expense')->name('expense.')->middleware(['auth:api', 'verified', 'authorized'])->group(function () {
    // routes for Expense Category controller
    Route::prefix('/category')->name('category.')->controller(ExpenseCategoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('/search', 'search')->name('search');
    });
    // routes for Expense sub-category controller
    Route::prefix('/sub-category')->name('sub.category')->controller(ExpenseSubCategoryController::class)->group(function () {
        Route::post('/store', 'store')->name('store');
        Route::get('/{expenseCategory}', 'index')->name('index');
    });
    // all route for expense
    Route::controller(ExpenseController::class)->group(function () {
        Route::put('/update/user/{expense}', 'updateUser')->name('update.user');
        Route::put('/update/category/{expense}', 'updateCategory')->name('update.catgeory');
        Route::put('/update/sub-category/{expense}', 'updateSubCategory')->name('update.sub.category');
        Route::put('/update/description/{expense}', 'updateDescription')->name('update.description');
        Route::put('/update/amount/{expense}', 'updateAmount')->name('update.amount');
        Route::put('/update/payment-method/{expense}', 'updatePaymentMethod')->name('update.payment.method');
        Route::put('/update/payee/{expense}', 'updatePayee')->name('update.payee');
        Route::put('/update/reimbursable/{expense}', 'updateReimbursable')->name('update.reimburables');
        Route::put('/update/listings/{expense}', 'updateListing')->name('update.listings');
        Route::put('/update/note/{expense}', 'updateNote')->name('update.note');


        Route::post('/store/{expense_for}', 'store')->name('store');
        Route::get('/{expense_for}', 'index')->name('index');

    });
});
