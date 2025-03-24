<?php
use App\Http\Controllers\API\V1\PasswordList\PasswordListController;
use Illuminate\Support\Facades\Route;

// all password_list category route of password_list
Route::prefix('v1/password-list')->name('password-list.')->middleware(['auth:api', 'verified',])->group(function () {
    Route::middleware(['authorized'])->controller(PasswordListController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/single/{passwordListSlug}', 'show')->name('show');
        Route::post('/store', 'store')->name('store');
        Route::post('/update/{passwordListSlug}', 'update')->name('update');
        Route::delete('/delete/{passwordListSlug}', 'destroy')->name('delete');
    });
});
