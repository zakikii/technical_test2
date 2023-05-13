<?php

use App\Http\Controllers\API\LocationController;
use App\Http\Controllers\Auth\RegisterController;
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

Route::get('register/check', [RegisterController::class, 'check'])->name('api-register-check');
Route::get('provinces', [LocationController::class, 'provinces'])->name('api-provinces');
Route::get('regencies/{provinces_id}', [LocationController::class, 'regencies'])->name('api-regencies');
Route::post('login', [\App\Http\Controllers\API\UserController::class, 'login']);
Route::post('register', [\App\Http\Controllers\API\UserController::class, 'register']);
Route::get('user', [\App\Http\Controllers\API\UserController::class, 'getAuthenticatedUser'])->middleware('jwt.verify');
Route::get('userpurchases', [\App\Http\Controllers\API\ProductController::class, 'userPurchases'])->middleware('jwt.verify');
Route::post('checkout', [\App\Http\Controllers\API\ProductController::class, 'checkoutItem'])->middleware('jwt.verify');
Route::post('addcart', [\App\Http\Controllers\API\ProductController::class, 'addCart'])->middleware('jwt.verify');
Route::get('listproduct', [\App\Http\Controllers\API\SellerController::class, 'listProducts'])->middleware('jwt.verify');
Route::post('changestatus', [\App\Http\Controllers\API\SellerController::class, 'changeStatusTransaction'])->middleware('jwt.verify');