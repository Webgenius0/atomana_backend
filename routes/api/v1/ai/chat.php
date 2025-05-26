<?php

use App\Http\Controllers\API\V1\AI\MyAI\MyAIController;
use App\Http\Controllers\API\V1\AI\MyPR\MyPRController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1/my-ai')->name('my.ai.')->middleware('authorized')->controller(MyAIController::class)->group(function () {
    Route::get('/chat', 'index')->name('chat.index');
    Route::post('/chat', 'storeChat')->name('chat.store');
    Route::get('/chat/{myAI}', 'show')->name('chat.message.show');
    Route::post('/chat/{myAI}', 'message')->name('chat.message.store');
    // Route::post('/ask-ai',  'chat')->name('ask-ai');
});

Route::prefix('/v1/my-pr')->name('my.pr.')->middleware('authorized')->controller(MyPRController::class)->group(function () {
    Route::get('/chat', 'index')->name('chat.index');
    Route::post('/chat', 'storeChat')->name('chat.store');
    Route::get('/chat/{myPR}', 'show')->name('chat.message.show');
    Route::post('/chat/{myPR}', 'message')->name('chat.message.store');
});
