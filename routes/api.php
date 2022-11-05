<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
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

Route::get('/countries', [CountryController::class, 'index']);
Route::get('/countries/{country}', [CountryController::class, 'show']);
Route::post('/countries', [CountryController::class, 'store']);
Route::delete('/countries/{country}', [CountryController::class, 'destroy']);
Route::get('/countries/{country}/cities', [CountryController::class, 'byCity']);

Route::get('/cities', [CityController::class, 'index']);
Route::get('/cities/{city}', [CityController::class, 'show']);
Route::post('/cities', [CityController::class, 'store']);
Route::delete('/cities/{city}', [CityController::class, 'destroy']);


#Route::group([
#    'middleware' => 'api',
#    'prefix' => 'auth'
#], function ($router) {
#    Route::post('/login', [AuthController::class, 'login']);
#    Route::post('/logout', [AuthController::class, 'logout']);
#    Route::post('/refresh', [AuthController::class, 'refresh']);
#    Route::get('/user', [AuthController::class, 'userProfile']);
#});
