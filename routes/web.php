<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/locations', [LocationController::class, 'index']);
Route::get('/api/locations/{id}', [LocationController::class, 'show']);
