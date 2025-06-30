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
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Authenticated routes
 */
Route::middleware('auth:sanctum')->group(function () {
    /**
     * Log out the authenticated user.
     *
     * @route POST /logout
     * @controller AuthController@logout
     */
    Route::post('/logout', [AuthController::class, 'logout']);

    /**
     * Get the authenticated user's profile.
     *
     * @route GET /profile
     * @controller AuthController@profile
     */
    Route::get('/profile', [AuthController::class, 'profile']);

    Route::post('/profile/update', [AuthController::class, 'updateProfile']);

    Route::post('/profile/change-password', [AuthController::class, 'changePassword']);
});

/**
 * Register a new user.
 *
 * @route POST /register
 * @controller AuthController@register
 */
Route::post('register', [AuthController::class, 'register']);

/**
 * Log in a user and create a token.
 *
 * @route POST /login
 * @controller AuthController@login
 */
Route::post('login', [AuthController::class, 'login'])->name('login');

/**
 * Store a newly created movie in storage.
 *
 * @route POST /movies
 * @controller MoviesController@store
 */
Route::post('movies', [MoviesController::class, 'store']);

/**
 * Display a listing of the movies.
 *
 * @route GET /movies
 * @controller MoviesController@index
 */
Route::get('movies', [MoviesController::class, 'index']);

/**
 * Display the specified movie.
 *
 * @route GET /movies/{id}
 * @controller MoviesController@show
 */
Route::get('movies/{id}', [MoviesController::class, 'show']);

/**
 * Update the specified movie in storage.
 *
 * @route patch /movies/{id}
 * @controller MoviesController@update
 */
Route::patch('movies/{id}', [MoviesController::class, 'update']);

/**
 * Remove the specified movie from storage.
 *
 * @route DELETE /movies/{id}
 * @controller MoviesController@destroy
 */
Route::delete('movies/{id}', [MoviesController::class, 'destroy']);

/**
 * Display the specified image.
 *
 * @route GET /showImage/{filename}
 * @controller MoviesController@showImage
 */
Route::get('showImage/{filename}', [MoviesController::class, 'showImage']);