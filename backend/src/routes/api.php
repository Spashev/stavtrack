<?php

use App\Http\Controllers\Api\Auth\ApiAuthController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\VehicleTypeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('vehicles', VehicleController::class);
    Route::apiResource('types', VehicleTypeController::class);
});

Route::middleware(['cors', 'json.response'])->group(function() {
    Route::post('/login', [ApiAuthController::class, 'login']);
    Route::post('/register',[ApiAuthController::class, 'register']);
    Route::post('/logout', [ApiAuthController::class, 'logout']);
});
