<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocationController;

Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});

Route::get('/locations', [LocationController::class, 'index']);
Route::get('/locations/{id}', [LocationController::class, 'show']);
