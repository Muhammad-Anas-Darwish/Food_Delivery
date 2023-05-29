<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FoodCartController;

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

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', [UserController::class, 'details']);
});

// Profile routes
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('/profile', [ProfileController::class, 'store']);
    Route::get('/profile', [ProfileController::class, 'show']);
});

// Category routes
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{slug}', [CategoryController::class, 'show']);
Route::group(['middleware' => 'admin', 'middleware' => 'auth:api'], function() {
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{slug}', [CategoryController::class, 'update']);
    Route::delete('/categories/{slug}', [CategoryController::class, 'destroy']);
});

// Country routes
Route::get('/countries', [CountryController::class, 'index']);
Route::get('/countries/{id}', [CountryController::class, 'show']);
Route::group(['middleware' => 'admin', 'middleware' => 'auth:api'], function() {
    Route::post('/countries', [CountryController::class, 'store']);
    Route::put('/countries/{id}', [CountryController::class, 'update']);
    Route::delete('/countries/{id}', [CountryController::class, 'destroy']);
});

// City routes
Route::get('/cities', [CityController::class, 'index']);
Route::get('/cities/{id}', [CityController::class, 'show']);
Route::group(['middleware' => 'admin', 'middleware' => 'auth:api'], function() {
    Route::post('/cities', [CityController::class, 'store']);
    Route::put('/cities/{id}', [CityController::class, 'update']);
    Route::delete('/cities/{id}', [CityController::class, 'destroy']);
});

// Food routes
Route::get('/foods', [FoodController::class, 'index']);
Route::get('/foods/{slug}', [FoodController::class, 'show']);
Route::group(['middleware' => 'admin', 'middleware' => 'auth:api'], function() {
    Route::post('/foods', [FoodController::class, 'store']);
    Route::put('/foods/{slug}', [FoodController::class, 'update']);
    Route::delete('/foods/{slug}', [FoodController::class, 'destroy']);
});

// Cart routes
Route::group(['middleware' => 'auth:api'], function() {
    // Route::get('/carts', [CartController::class, 'index']);
    Route::get('/carts/my_cart', [CartController::class, 'show']);
    Route::post('/carts', [CartController::class, 'store']);
});

// Food Cart routes
// Route::get('/food_carts/my_cart', [FoodCartController::class, 'show']);
Route::group(['middleware' => 'auth:api'], function() {
    Route::get('/food_carts', [FoodCartController::class, 'getCartItems']);
    Route::post('/food_carts', [FoodCartController::class, 'store']);
    Route::put('/food_carts/{id}', [FoodCartController::class, 'update']);
    Route::delete('/food_carts/{id}', [FoodCartController::class, 'destroy']);
});

Route::group(['middleware' => 'admin', 'middleware' => 'auth:api'], function() {

});
