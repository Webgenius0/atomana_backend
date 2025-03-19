<?php
use App\Http\Controllers\API\V1\SharedNote\SharedNoteController;
use Illuminate\Support\Facades\Route;

// all shared_note category route of shared_note
Route::prefix('v1/shared-note')->name('shared-note.')->middleware(['auth:api', 'verified',])->group(function () {
    Route::middleware(['authorized'])->controller(SharedNoteController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/single/{sharedNoteSlug}', 'show')->name('show');
        Route::post('/store', 'store')->name('store');
    });
});


