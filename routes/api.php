<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\EateryController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AccomodationController;

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
Route::get('/countries/{country}/cities', [CountryController::class, 'cities']);

Route::get('/cities', [CityController::class, 'index']);
Route::get('/cities/{city}', [CityController::class, 'show']);
Route::post('/cities', [CityController::class, 'store']);
Route::delete('/cities/{city}', [CityController::class, 'destroy']);
Route::get('/cities/{city}/eateries', [CityController::class, 'eateries']);
Route::get('/cities/{city}/activities', [CityController::class, 'activities']);
Route::get('/cities/{city}/accomodations', [CityController::class, 'accomodations']);

Route::get('/eateries', [EateryController::class, 'index']);
Route::get('/eateries/{eatery}', [EateryController::class, 'show']);
Route::post('/eateries', [EateryController::class, 'store']);
Route::delete('/eateries/{eatery}', [EateryController::class, 'destroy']);

Route::get('/accomodations', [AccomodationController::class, 'index']);
Route::get('/accomodations/{accomodation}', [AccomodationController::class, 'show']);
Route::post('/accomodations', [AccomodationController::class, 'store']);
Route::delete('/accomodations/{accomodation}', [AccomodationController::class, 'destroy']);

Route::get('/activities', [ActivityController::class, 'index']);
Route::get('/activities/{activity}', [ActivityController::class, 'show']);
Route::post('/activities', [ActivityController::class, 'store']);
Route::delete('/activities/{activity}', [ActivityController::class, 'destroy']);

Route::get('/routes', [RouteController::class, 'index']);
Route::get('/routes/{route}', [RouteController::class, 'show']);
Route::delete('/routes/{route}', [RouteController::class, 'destroy']);
Route::put('/routes/{route}/progress', [RouteController::class, 'updateProgress']);
Route::get('/routes/{route}/activities', [RouteController::class, 'activities']);

Route::get('/travels', [TravelController::class, 'index']);
Route::get('/travels/{travel}', [TravelController::class, 'show']);
Route::get('/travels/{travel}/eateries', [TravelController::class, 'eateries']);
Route::post('/travels', [TravelController::class, 'store']);
Route::delete('/travels/{travel}', [TravelController::class, 'destroy']);

#Route::group([
#    'middleware' => 'api',
#    'prefix' => 'auth'
#], function ($router) {
#    Route::post('/login', [AuthController::class, 'login']);
#    Route::post('/logout', [AuthController::class, 'logout']);
#    Route::post('/refresh', [AuthController::class, 'refresh']);
#    Route::get('/user', [AuthController::class, 'userProfile']);
#});
