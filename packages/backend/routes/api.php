<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:api')->group(function () {
    Route::get('bookings/', [\App\Http\Controllers\API\BookingController::class, 'index']);
    Route::post('bookings/', [\App\Http\Controllers\API\BookingController::class, 'store']);
    Route::post('bookings/', [\App\Http\Controllers\API\BookingController::class, 'store']);
    Route::post('logout/', [\App\Http\Controllers\API\AuthController::class, 'logout']);
});

Route::post('login/', [\App\Http\Controllers\API\AuthController::class, 'login']);
Route::post('register/', [\App\Http\Controllers\API\AuthController::class, 'register']);
