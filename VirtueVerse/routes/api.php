<?php

use App\Http\Controllers\InsightsController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/insights/retrieveBookRecommendations', [InsightsController::class, 'retrieveBookRecommendations'])->name('insights.retrieveBookRecommendations');
Route::post('/insights/retrievePopularBooks', [InsightsController::class, 'retrievePopularBooks'])->name('insights.retrievePopularBooks');
Route::post('/insights/retrieveExpectedCompletionTime', [InsightsController::class, 'retrieveExpectedCompletionTime'])->name('insights.retrieveExpectedCompletionTime');