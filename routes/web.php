<?php

use App\Http\Controllers\GoogleLogin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayPalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


/**
 * Checkout Routes
 */
Route::group(['middleware' => 'auth:api'], function() {
    Route::get('trans', function () {
        return view('paywithpaypal');
    })->name('createTransaction');
});

/**
 * Google Routes
 */
Route::get('google',function () {
    return view('googleAuth');
});

/**
 * Food Store Routes
 */
Route::get('food/store',function () {
    return view('food');
});
