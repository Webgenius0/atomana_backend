<?php

use App\Http\Controllers\API\V1\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

// all profile route of profile
Route::prefix('v1/profile')->name('profile.')->middleware(['auth:api', 'verified',])->group(function () {

    // routes for bouth admin and agents
    Route::middleware(['authorized'])->controller(ProfileController::class)->group(function () {
        Route::get('/show', 'show')->name('show');

        Route::put('/address', 'address')->name('address');
        Route::put('/phone', 'phone')->name('phone');
        Route::put('/birthday', 'birthday')->name('birthday');
        Route::put('/anniversary-home-addrress', 'anniversaryHomeAddrress')->name('anniversary.home.addrress');
        Route::put('/social-media', 'socialMedia')->name('social.media');
        Route::put('/about', 'about')->name('about');
    });
});
