<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardProductController;
use App\Http\Controllers\DashboardSettingController;
use App\Http\Controllers\DashboardTransactionController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\TransactionController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/categories/{id}', [CategoryController::class, 'detail']) ->name('categories-detail');

Route::get('/details/{id}', [DetailController::class, 'index'])->name('detail');
Route::post('/details/{id}', [DetailController::class, 'add'])->name('detail-add');



Route::get('/success', [CartController::class, 'success'])->name('success');

Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout');
Route::post('/checkout/callback', [CheckoutController::class, 'proccess'])->name('midtrans-callback');



Route::get('/register/success', [RegisterController::class, 'success'])->name('success');


route::group(['middleware' => ['auth']], function() {
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::delete('/cart/{id}', [CartController::class, 'delete'])->name('cart-delete');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout');


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/products', [DashboardProductController::class, 'index'])->name('dashboard-product');
Route::get('/dashboard/products/create', [DashboardProductController::class, 'create'])->name('dashboard-product-create');
Route::post('/dashboard/products', [DashboardProductController::class, 'store'])->name('dashboard-product-store');


Route::get('/dashboard/products/{id}', [DashboardProductController::class, 'details'])->name('dashboard-product-details');
Route::post('/dashboard/transactions/{id}', [DashboardTransactionController::class, 'update'])->name('dashboard-transaction-update');

Route::post('/dashboard/products/{id}', [DashboardProductController::class, 'update'])->name('dashboard-product-update');

Route::post('/dashboard/products/gallery/upload', [DashboardProductController::class, 'uploadGallery'])->name('dashboard-product-gallery-upload');
Route::get('/dashboard/products/gallery/delete/{id}', [DashboardProductController::class, 'deleteGallery'])->name('dashboard-product-gallery-delete');



Route::get('/dashboard/transactions', [DashboardTransactionController::class, 'index'])->name('dashboard-transaction');
Route::get('/dashboard/transactions/{id}', [DashboardTransactionController::class, 'details'])->name('dashboard-transaction-details');
Route::get('/dashboard/purchase/{id}', [DashboardTransactionController::class, 'details2'])->name('dashboard-purchase-details');
Route::get('/dashboard/settings', [DashboardSettingController::class, 'store'])->name('dashboard-settings-store');
Route::get('/dashboard/account', [DashboardSettingController::class, 'account'])->name('dashboard-settings-account');
Route::post('/dashboard/account/{redirect}', [DashboardSettingController::class, 'update'])->name('dashboard-settings-redirect');



});

// ->middleware(['auth','admin'])
Route::prefix('admin')
    ->middleware(['auth','admin'])
    ->group(function(){
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index']) ->name('admin-dashboard');
        Route::resource('category', AdminCategoryController::class);
        Route::resource('user', AdminUserController::class);
        Route::resource('product', AdminProductController::class);
         Route::resource('product-gallery', ProductGalleryController::class);
         Route::resource('transaction', TransactionController::class);



      
    });








Auth::routes();


