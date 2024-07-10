<?php

use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ProductDetailController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\ProductSearchController;
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
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{slug}', [PostController::class, 'show']);
Route::get('/products/{slug?}', [ProductController::class, 'index']);

Route::get('/categories/{slug?}', [CategoryController::class, 'index']);

Route::get('/cart', [CartController::class, 'index']);
Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart']);
Route::post('/update-to-cart/{id}', [CartController::class, 'updateToCart']);
Route::get('/remove-from-cart/{id}', [CartController::class, 'removeFromCart']);

Route::get('/checkout', [OrderController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);

Route::get('/contact', [ContactController::class, 'index']);

Route::get('/product_detail/{slug}', [ProductDetailController::class, 'index']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/profile', [ProfileController::class, 'index']);
});

Route::get('/admin/orders/export', [\App\Http\Controllers\Admin\OrderController::class, 'export'])
    ->middleware('auth');

Route::get('/admin/orders/order_detail/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'export_order_detail'])
    ->middleware('auth');



Route::get('/admin/products/import', [\App\Http\Controllers\Admin\ProductController::class, 'import'])
    ->middleware('auth');
Route::post('/admin/products/import', [\App\Http\Controllers\Admin\ProductController::class, 'importExcelData'])
    ->middleware('auth');

