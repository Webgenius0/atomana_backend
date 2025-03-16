<?php

use App\Http\Controllers\API\V1\AI\MyAIController;
use Illuminate\Support\Facades\Route;

Route::post('/v1/ai/my-ai', [MyAIController::class, 'chat'])->middleware('authorized');
