<?php

use App\Http\Controllers\API\V1\AI\MyAI\MyAIController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/my-ai')->name('ai.')->controller(MyAIController::class)->group(function () {
    Route::post('/chat', 'storeChat')->name('chat');
});
