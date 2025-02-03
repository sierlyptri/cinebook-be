<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\TheatersController;
use App\Http\Controllers\ShowtimesController;
use App\Http\Controllers\SeatsController;
use App\Http\Controllers\BookingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);
    Route::get('/user', [App\Http\Controllers\AuthController::class, 'user']);
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('movies', [MoviesController::class, 'store']);
Route::get('movies', [MoviesController::class, 'index']);
Route::get('movies/{id}', [MoviesController::class, 'show']);
Route::put('movies/{id}', [MoviesController::class, 'update']);
Route::delete('movies/{id}', [MoviesController::class, 'destroy']);
Route::get('showImage/{filename}', [MoviesController::class, 'showImage']);
Route::post('theaters', [TheatersController::class, 'store']);
Route::get('theaters', [TheatersController::class, 'index']);
Route::get('theaters/{id}', [TheatersController::class, 'show']);
Route::put('theaters/{id}', [TheatersController::class, 'update']);
Route::delete('theaters/{id}', [TheatersController::class, 'destroy']);
Route::post('showtimes', [ShowtimesController::class, 'store']);
Route::get('showtimes', [ShowtimesController::class, 'index']);
Route::get('showtimes/{id}', [ShowtimesController::class, 'show']);
Route::put('showtimes/{id}', [ShowtimesController::class, 'update']);
Route::delete('showtimes/{id}', [ShowtimesController::class, 'destroy']);
Route::get('seats/{showtime}', [SeatsController::class, 'index']);
Route::post('seats', [SeatsController::class, 'store'])->name('seats.store');
Route::post('book', [SeatsController::class, 'book'])->name('seats.book');