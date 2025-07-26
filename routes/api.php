<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\TheatersController;
use App\Http\Controllers\ShowtimesController;
use App\Http\Controllers\SeatsController;
use App\Http\Controllers\BookingsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Authenticated routes
 */
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});

Route::get('/movies', [MoviesController::class, 'index']);
Route::post('/movies', [MoviesController::class, 'store']);
Route::put('/movies/{id}', [MoviesController::class, 'update']);
Route::delete('/movies/{id}', [MoviesController::class, 'destroy']);
Route::get('/movies/images/{filename}', [MoviesController::class, 'showImage']);

Route::get('/theaters', [TheatersController::class, 'index']);
Route::post('/theaters', [TheatersController::class, 'store']);
Route::put('/theaters/{id}', [TheatersController::class, 'update']);
Route::delete('/theaters/{id}', [TheatersController::class, 'destroy']);

Route::get('/showtimes', [ShowtimesController::class, 'index']);
Route::post('/showtimes', [ShowtimesController::class, 'store']);
Route::put('/showtimes/{id}', [ShowtimesController::class, 'update']);
Route::delete('/showtimes/{id}', [ShowtimesController::class, 'destroy']);

Route::get('/seats/{showtimes_id}', [SeatsController::class, 'index']);
Route::post('/seats', [SeatsController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/bookings', [BookingsController::class, 'index']);
    Route::post('/bookings', [BookingsController::class, 'store']);
    Route::get('/bookings/{id}', [BookingsController::class, 'show']);
    Route::delete('/bookings/{id}', [BookingsController::class, 'destroy']);
});