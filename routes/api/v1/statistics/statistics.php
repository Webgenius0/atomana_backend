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

        Route::get('/expenses/{filter}', 'expenses')->name('expenses')
            ->where('filter', 'monthly|quarterly|yearly');

        Route::get('/net-profit/{filter}', 'netProfit')->name('net.profit')
            ->where('filter', 'monthly|quarterly|yearly');

        Route::get('/agent-data/{userId}/{filter}', 'agentData')->name('agent.data')
            ->where('filter', 'monthly|quarterly|yearly');

        Route::get('/leaderboard/{sortedBy}/{filter}', 'leaderboard')->name('leaderboard')
            ->where('sortedBy', 'highest-avg-sales|highest-sold-volume')
            ->where('filter', 'monthly|quarterly|yearly');
    });
});
