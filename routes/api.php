<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);


#Route::group([
#    'middleware' => 'api',
#    'prefix' => 'auth'
#], function ($router) {
#    Route::post('/login', [AuthController::class, 'login']);
#    Route::post('/logout', [AuthController::class, 'logout']);
#    Route::post('/refresh', [AuthController::class, 'refresh']);
#    Route::get('/user', [AuthController::class, 'userProfile']);
#});
