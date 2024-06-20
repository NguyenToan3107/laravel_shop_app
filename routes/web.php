<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ProductDetailController;
use App\Http\Controllers\Frontend\ProfileController;
use Illuminate\Support\Facades\Route;

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


require __DIR__ . '/auth.php';

Route::get('/', [HomeController::class, 'index']);
Route::get('/blog', [BlogController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/cart', [CartController::class, 'index']);
Route::get('/checkout', [CartController::class, 'checkout']);
Route::get('/contact', [ContactController::class, 'index']);
Route::get('/product_detail', [ProductDetailController::class, 'index']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/profile', [ProfileController::class, 'index']);
});



