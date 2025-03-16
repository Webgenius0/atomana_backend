<?php

use App\Http\Controllers\API\V1\AI\MyAI\MYAIController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/my-ai')->name('ai.')->controller(MYAIController::class)->group(function () {
    Route::post('/message', 'store')->name('store');
});
