<?php

use App\Helpers\Helper;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// Clear all cache and optimize the application
Route::get('/v1/optimize-clear', function (): JsonResponse {
    Artisan::call('optimize:clear');
    return Helper::success(200, 'Cache cleared and application optimized successfully.');
});

// Run migrations
Route::get('/v1/migrate', function () : JsonResponse{
    Artisan::call('migrate');
    return Helper::success(200, 'Migrations ran successfully.');
});

// Run fresh migrations (drop all tables and run migrations again)
Route::get('/v1/migrate-fresh', function (): JsonResponse {
    Artisan::call('migrate:fresh');
    return Helper::success(200, 'Database refreshed and migrations run successfully.');
});

// Run fresh migrations and seed the database
Route::get('/v1/migrate-fresh-seed', function () : JsonResponse{
    Artisan::call('migrate:fresh --seed');
    return Helper::success(200, 'Database refreshed, migrations run, and seeding completed successfully.');
});

// Seed the database
Route::get('/v1/seed', function () : JsonResponse{
    Artisan::call('db:seed');
    return Helper::success(200, 'Database seeding completed successfully.');
});

//queue-work
Route::get('/v1/queue-work', function (): JsonResponse {
    Artisan::call('queue:work --stop-when-empty');
    return Helper::success(200, 'Queue worker started successfully.');
});


// Run composer update
Route::get('/v1/composer-update', function () : JsonResponse{
    $output = shell_exec('composer update 2>&1');
    return Helper::success(200, 'Composer update completed.', $output);
});
