<?php


use App\Http\Controllers\API\V1\Statistic\HomeStatisticController;
use Illuminate\Support\Facades\Route;


// all profile route of sales track
Route::prefix('v1/statistic')->name('statistic.')->middleware(['auth:api', 'verified',])->group(function () {
    Route::middleware(['authorized'])->controller(HomeStatisticController::class)->group(function () {

        Route::get('/current-sales/{filter}', 'currentSales')->name('current.sales')
        ->where('filter', 'monthly|quarterly|yearly');

        Route::get('/units-sold/{filter}', 'unitsSold')->name('units.sold')
        ->where('filter', 'monthly|quarterly|yearly');
    });
});
